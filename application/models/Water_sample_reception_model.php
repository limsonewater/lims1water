<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Water_sample_reception_model extends CI_Model
{

    public $table = 'sample_reception';
    public $id = 'project_id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('sample_reception.project_id, sample_reception.client_id, 
        ref_client.client_name, sample_reception.date_arrival, sample_reception.time_arrival, 
        sample_reception.comments, sample_reception.flag');
        $this->datatables->from('sample_reception');
        $this->datatables->join('ref_client', 'sample_reception.client_id = ref_client.client_id', 'left');
        // $this->datatables->where('Water_sample_reception.id_country', $this->session->userdata('lab'));
        $this->datatables->where('sample_reception.flag', '0');
        $lvl = $this->session->userdata('id_user_level');
        if ($lvl == 7){
            $this->datatables->add_column('action', anchor(site_url('Water_sample_reception/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')), 'project_id');
        }
        else if (($lvl == 2) | ($lvl == 3)){
            $this->datatables->add_column('action', anchor(site_url('Water_sample_reception/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')) ."
                ".'<button type="button" class="btn_edit btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>', 'project_id');
        }
        else {
            $this->datatables->add_column('action', anchor(site_url('Water_sample_reception/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')) ."
                ".'<button type="button" class="btn_edit btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'." 
                ".anchor(site_url('Water_sample_reception/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Confirm deleting project ID : $1 ?\')"'), 'project_id');
        }
        return $this->datatables->generate();
    }

    function subjson($id) {
        $this->datatables->select('sample_id, project_id, sample_description, flag');
        $this->datatables->from('sample_reception_sample');
        $this->datatables->where('flag', '0');
        $this->datatables->where('project_id', $id);
        $lvl = $this->session->userdata('id_user_level');
        if ($lvl == 7){
            $this->datatables->add_column('action', anchor(site_url('Water_sample_reception/read2/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')), 'sample_id');
        }
        else if (($lvl == 2) | ($lvl == 3)){
            $this->datatables->add_column('action', anchor(site_url('Water_sample_reception/read2/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')) ."
                ".'<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>', 'sample_id');
        }
        else {
            $this->datatables->add_column('action', anchor(site_url('Water_sample_reception/read2/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')) ."
                ".'<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'." 
                ".anchor(site_url('Water_sample_reception/delete_detail/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Confirm deleting sample ID : $1 ?\')"'), 'sample_id');
        }

    //   if ($lvl == 7){
    //       $this->datatables->add_column('action', '', 'sample_id');
    //   }
    //   else if (($lvl == 2) | ($lvl == 3)){
    //         $this->datatables->add_column('action', '<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>', 'sample_id');
    //   }
    //   else {
    //         $this->datatables->add_column('action', '<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'." 
    //             ".anchor(site_url('Water_sample_reception/delete_detail/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Confirm deleting this sample?\')"'), 'sample_id');
    //     }
        return $this->datatables->generate();
    }

    function subjson2($id2) {
        $this->datatables->select('a.testing_id, b.testing_type, a.date_collected, a.time_collected, a.no_submitted, a.sample_barcode, a.flag');
        $this->datatables->from('sample_reception_testing a');
        $this->datatables->join('ref_testing b', 'a.testing_type_id = b.testing_type_id', 'left');
        $this->datatables->where('a.sample_id', $id2);
        $this->datatables->where('a.flag', '0');

        $lvl = $this->session->userdata('id_user_level');
        if ($lvl == 7){
            $this->datatables->add_column('action', '', 'testing_id');
        }
        else if (($lvl == 2) | ($lvl == 3)){
            $this->datatables->add_column('action', '<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>', 'testing_id');
        }
        else {
            $this->datatables->add_column('action', '<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'." 
                ".anchor(site_url('Water_sample_reception/delete_detail2/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Confirm deleting this sample testing ID : $1?\')"'), 'testing_id');
            }
        return $this->datatables->generate();
    }


    // function get_all_with_detail_excel($id)
    // {
    //     $data = $this->db->select('a.date_req, a.title, c.realname , d.objective, a.budget_req, a.comments, 
    //     b.id_reqdetail, b.items, b.qty, e.unit, b.estimate_price, g.sum_tot,
    //     (b.estimate_price * b.qty) AS total, b.remarks, d.reviewed, d.approved')
    //         ->from("Water_sample_reception a")
    //         ->join('Water_sample_reception_detail b', 'a.id_req = b.id_req', 'left')
    //         ->join('ref_person c', 'a.id_person = c.id_person', 'left')
    //         ->join('ref_objective d', 'a.id_objective = d.id_objective ', 'left')
    //         ->join('ref_unit e', 'b.id_unit = e.id_unit ', 'left')
    //         ->join('v_req_sum g', 'a.id_req=g.id_req', 'left')
    //         ->where('a.id_req', $id)
    //         ->where('a.flag', 0)
    //         ->where('b.flag', 0)
    //         // ->where('l.id', $this->session->userdata('location_id'))
    //         ->get()->result();
    //         // foreach ($data as $row) {
    //         //     // Format estimate_price to show as money value
    //         //     $row->estimate_price = number_format($row->estimate_price, 0, '.', ',');
    //         //     // Format total_price to show as money value
    //         //     $row->total = number_format($row->total, 0, '.', ',');
    //         // }            
    //         return $data;
    // }

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        $this->db->where('flag', '0');
        // $this->db->where('lab', $this->session->userdata('lab'));
        return $this->db->get($this->table)->row();
    }

    // function get_by_id2($id)
    // {
    //     $this->db->where($this->id, $id);
    //     $this->db->where('flag', '0');
    //     // $this->db->where('lab', $this->session->userdata('lab'));
    //     return $this->db->get('v_get_bud_req')->row();
    // }

    function get_by_id_detail($id)
    {
        $this->db->where('sample_id', $id);
        $this->db->where('flag', '0');
        // $this->db->where('lab', $this->session->userdata('lab'));
        return $this->db->get('sample_reception_sample')->row();
    }

    // Function get detail2 by id
    function get_by_id_detail2($id)
    {
        $this->db->where('testing_id', $id);
        $this->db->where('flag', '0');
        return $this->db->get('sample_reception_testing')->row();
    }

    function get_detail($id)
    {
      $response = array();
      $this->db->select('*');
      $this->db->join('ref_client', 'sample_reception.client_id=ref_client.client_id', 'left');
      $this->db->where('sample_reception.project_id', $id);
      // $this->db->where('lab', $this->session->userdata('lab'));
      $this->db->where('sample_reception.flag', '0');
      $q = $this->db->get('sample_reception');
      $response = $q->row();
      return $response;
        // $this->db->where('id_spec', $id_spec);
        // $this->db->where('flag', '0');
        // // $this->db->where('lab', $this->session->userdata('lab'));
        // return $this->db->get('obj2b_spectro_crm')->row();
    }

    function get_detail2($id)
    {
      $response = array();
      $this->db->select('*');
      $this->db->where('sample_reception_sample.sample_id', $id);
      $this->db->where('sample_reception_sample.flag', '0');
      $q = $this->db->get('sample_reception_sample');
      $response = $q->row();
      return $response;
    }

    // function getSumEstimatePrice($id_req) {
    //     $this->db->select_sum('estimate_price');
    //     $this->db->where('id_req', $id_req);
    //     $query = $this->db->get('Water_sample_reception_detail');
    //     return $query->row()->estimate_price;
    // }

    function get_rep($id)
    {
        // $q = $this->db->query('SELECT a.id_req, a.date_req, b.realname, c.objective, a.title, 
        // DATE_FORMAT(a.date_req, "%M %Y") AS periode, FORMAT(a.budget_req, 0, "de_DE") AS budget_req,
        // a.comments, a.flag, c.reviewed, c.approved
        // FROM Water_sample_reception a
        // LEFT JOIN ref_person b ON a.id_person=b.id_person 
        // LEFT JOIN ref_objective c ON a.id_objective=c.id_objective
        // WHERE a.id_req="'.$id.'"
        // AND a.flag = 0 
        // ');        
        // $response = $q->row();
        // return $response;
      }


    //   function get_repdet($id)
    //   {
    //       $q = $this->db->query('SELECT * FROM Water_sample_reception_detail
    //       WHERE flag = 0
    //       AND id_spec="'.$id.'"');        
    //       $response = $q->row();
    //       return $response;
    //     }


    // Function to get the latest project_id
        private function get_latest_project_id() {
            $this->db->select('project_id');
            $this->db->order_by('project_id', 'DESC');
            $this->db->limit(1);
            $query = $this->db->get('sample_reception');
    
            // Check if there is a previous project_id
            if ($query->num_rows() > 0) {
                return $query->row()->project_id;
            } else {
                return null;
            }
        }
    
    // Function to generate the next project_id
        private function generate_project_id() {
            $latest_id = $this->get_latest_project_id();
    
            if ($latest_id) {
                $parts = explode('-', $latest_id);
                $number = intval($parts[1]) + 1;
                $new_id = sprintf('%s-%05d', '24', $number);
                return $new_id;
            } else {
                // If there is no previous project_id, start from '24-00001'
                return '24-00001';
            }
        }
    

    // Fuction insert data
        public function insert($data) {
            $data['project_id'] = $this->generate_project_id();
            $this->db->insert($this->table,  $data);
        }
    

    // Function update data
        function update($id, $data)
        {
            $this->db->where('project_id', $id);
            $this->db->update('sample_reception', $data);
        }

    function insert_det($data)
    {
        $this->db->insert('sample_reception_sample', $data);
    }
    

    function update_det($id, $data)
    {
        $this->db->where('sample_id', $id);
        $this->db->update('sample_reception_sample', $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function delete_detail($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    // Function insert detail 2
    function insert_det2($data)
    {
        $this->db->insert('sample_reception_testing', $data);
    }
    
    // Function update detail 2
    function update_det2($id, $data)
    {
        $this->db->where('testing_id', $id);
        $this->db->update('sample_reception_testing', $data);
    }

    // Function delete detail 2
    function delete_detail2($id)
    {
        $this->db->where('testing_id', $id);
        $this->db->delete('sample_reception_testing');
    }
    

    function getClient(){
        $response = array();
        $this->db->select('*');
        // $this->db->where('position', 'Lab Tech');
        $this->db->where('flag', '0');
        $this->db->order_by('client_name');
        $q = $this->db->get('ref_client');
        $response = $q->result_array();
        return $response;
      }

    function getLabtech(){
        // $response = array();
        // $this->db->select('*');
        // // $this->db->where('position', 'Lab Tech');
        // $this->db->where('flag', '0');
        // // $this->db->where('id_country', $this->session->userdata('lab'));
        // $this->db->order_by('realname');
        // $q = $this->db->get('ref_person');
        // $response = $q->result_array();
        // return $response;
      }

      function getObjective(){
        // $response = array();
        // $this->db->select('*');
        // // $this->db->where('position', 'Lab Tech');
        // $this->db->where('flag', '0');
        // // $this->db->where('id_country', $this->session->userdata('lab'));
        // $q = $this->db->get('ref_objective');
        // $response = $q->result_array();
        // return $response;
      }

      function getTest(){
        $response = array();
        $this->db->select('*');
        $this->db->where('flag', '0');
        $q = $this->db->get('ref_testing');
        $response = $q->result_array();
        return $response;
      }
      
}

/* End of file Tbl_delivery_model.php */
/* Location: ./application/models/Tbl_delivery_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:38:42 */
/* http://harviacode.com */