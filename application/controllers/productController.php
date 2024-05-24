<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class productController extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('productModel');
        $this->load->helper('form','url');
        $this->load->library('form_validation');
    }

	public function show()
	{
        $data['products']=$this->productModel->get_products();
		$this->load->view('productlist',$data);
	}
	public function add()
	{
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');

        if($this->form_validation->run()===False){
            $this->load->view('create');
        }else{
            $data = array(
                'name'=>$this->input->post('name'),
                'description'=>$this->input->post('description'),
                'price'=>$this->input->post('price')

            );
            $this->productModel->insert_product($data);
            redirect('Product');
        }
	}
    public function edit($id) {

            $data['product'] = $this->productModel->get_product($id);
    
            if (empty($data['product'])) {
                show_404();
            }
    
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('price', 'Price', 'required|numeric');
    
            if ($this->form_validation->run() === FALSE) {
                $this->load->view('edit', $data);
            } else {
                $update_data = array(
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'price' => $this->input->post('price')
                );
                $this->productModel->update_product($id, $update_data);
                redirect('Product');
            }
        }

	public function delete($id)
	{
		$this->productModel->delete_product($id);
        redirect('Product');
        
	}

}
