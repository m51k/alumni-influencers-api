<?php

class Bid_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create($user_id, $slot_date, $amount)
    {
        $this->db->insert('bids', [
            'user_id' => $user_id,
            'slot_date' => $slot_date,
            'amount' => $amount,
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        return $this->db->insert_id();
    }

    public function get_by_id($id, $user_id)
    {
        return $this->db->where('id', $id)
            ->where('user_id', $user_id)
            ->get('bids')
            ->row();
    }

    public function get_active_bid($user_id, $slot_date)
    {
        $bid = $this->db->where('user_id', $user_id)
            ->where('slot_date', $slot_date)
            ->where('status', 'active')
            ->get('bids')
            ->row();

        if ($bid) {
            $highest = $this->get_highest_bid($slot_date);
            $bid->is_winning = ($highest && $highest->id === $bid->id);
        }

        return $bid;
    }

    public function get_history($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->order_by('created_at', 'DESC')
            ->get('bids')
            ->result();
    }

    public function get_monthly_win_count($user_id)
    {
        return $this->db->select('bids.id')
            ->from('bids')
            ->join('bid_winners', 'bid_winners.bid_id = bids.id')
            ->where('bids.user_id', $user_id)
            ->where('MONTH(bid_winners.selected_at) = MONTH(NOW())', NULL, FALSE)
            ->where('YEAR(bid_winners.selected_at) = YEAR(NOW())', NULL, FALSE)
            ->count_all_results();
    }

    public function has_event_attendance($user_id)
    {
        return $this->db->where('user_id', $user_id)
                ->where('MONTH(event_date) = MONTH(NOW())', NULL, FALSE)
                ->where('YEAR(event_date) = YEAR(NOW())', NULL, FALSE)
                ->count_all_results('event_attendance') > 0;
    }

    public function get_monthly_limit($user_id)
    {
        return $this->has_event_attendance($user_id) ? 4 : 3;
    }

    public function update_amount($id, $user_id, $amount)
    {
        $this->db->where('id', $id)
            ->where('user_id', $user_id)
            ->where('status', 'active')
            ->update('bids', ['amount' => $amount]);
    }

    public function cancel($id, $user_id)
    {
        $this->db->where('id', $id)
            ->where('user_id', $user_id)
            ->where('status', 'active')
            ->update('bids', ['status' => 'cancelled']);
    }

    public function get_highest_bid($slot_date)
    {
        return $this->db->where('slot_date', $slot_date)
            ->where('status', 'active')
            ->order_by('amount', 'DESC')
            ->limit(1)
            ->get('bids')
            ->row();
    }

    public function get_active_winner()
    {
        return $this->db->select('bid_winners.*, bids.user_id, bids.amount')
            ->from('bid_winners')
            ->join('bids', 'bids.id = bid_winners.bid_id')
            ->where('bid_winners.slot_date', date('Y-m-d'))
            ->get()
            ->row();
    }

    public function create_winner($bid_id, $slot_date)
    {
        $this->db->insert('bid_winners', [
            'bid_id' => $bid_id,
            'slot_date' => $slot_date,
            'selected_at' => date('Y-m-d H:i:s')
        ]);
    }
}