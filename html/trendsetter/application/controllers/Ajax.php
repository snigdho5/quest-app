<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Ajax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //CUSTOM CAPTCHA
        $this->load->library('custom_captcha');
    }
    public function index()
    {
        echo '';
    }

    public function setDisc()
    {
        $this->session->set_userdata(array('disc'=>'1'));
    }

    public function change_career_code(){
       $capData = $this->custom_captcha->generate('#000','#fff',110,37,10,100,'#555');
        $this->session->set_userdata(array('cap_career_text'=>$capData['text']));
        echo $capData['img'];
        //echo 'test';
    }

    public function career_submit(){
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone Number ', 'trim|required|exact_length[10]'); //{10} for 10 digits number
            //$this->form_validation->set_rules('post_appliction', 'Application for the post ', 'trim|required');
            $this->form_validation->set_rules('about', 'Message', 'trim');
            $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|exact_length[5]|in_list['.$this->session->userdata('cap_career_text').']',array('in_list' => "Invalid captcha code!"));
            if ($this->form_validation->run() !== false) {

                    $addArr = array(
                        'name' => $this->input->post('name'),
                        'email' => $this->input->post('email'),
                        'phone' => $this->input->post('phone'),
                        'profession' => $this->input->post('profession'),
                        'category' => implode(',',$this->input->post('category')),
                        'experience' => $this->input->post('experience'),
                        'preffered_social_media' => implode(',',$this->input->post('preffered_social_media')),
                        'curate_content' => $this->input->post('curate_content'),
                        'endorse_name' =>$this->input->post('endorse_name'),
                        'current_endorsing' => $this->input->post('current_endorsing'),
                        'social_links' => implode(',',$this->input->post('social_links')),
                        'facinating_piece' => $this->input->post('facinating_piece'),
                        'about' => $this->input->post('about'),
                        'created' => time()
                    );
                    $this->main_model->create('arg_trendsetter', $addArr);

                    $arr[] = array('type' => 'success', 'msg' => '<p>You Sign Up Successfully!</p>');
                    ///// Mail For User ///////////
                    $config = Array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'ssl://smtp.googlemail.com',
                        'smtp_port' => 465,
                        'smtp_user' => 'questmall1@gmail.com',
                        'smtp_pass' => 'questmall@123',
                        'mailtype'  => 'html',
                        'charset'   => 'iso-8859-1'
                    );
                    $emailForm = get_anydata('arg_site_setting','email',1);
                    $this->email->initialize($config);
                    $this->email->set_newline("\r\n");
                    $this->email->from('questmall1@gmail.com', 'Quest Trendsetter');
                    $this->email->to($this->input->post('email'));
                    $this->email->subject('Quest Trendsetter successful sign up!');
                    $message = '<!DOCTYPE html><html><body style="margin:0">';
                    $message.='<div style="padding:0 50px; text-align:center;"><p align="left">Hey <span>'.$this->input->post('name').','.'</span></p>';
                    $message.='<p align="left">Thank you for signing up to be a part of the Quest Trendsetter program.<br><br>
                    The team at Quest will get back to you soon on how to proceed.<br><br>
                    Meanwhile, why don\'t you show your love for Quest by following us on our social media pages.</p>';
                    $message.='<p align="left">Regards, <br> Quest Team<br><br>
                    <a target="_blank" href="https://www.facebook.com/questmallkolkata/"><img style="width:34px;" src="'.base_url().'images/facebook_icon.png" alt="" class="img-fluid socialicon"></a>
                    <a target="_blank" href="https://twitter.com/QuestKolkata"><img style="width:34px;" src="'.base_url().'images/twitter_icon.png" alt="" class="img-fluid socialicon"></a>
                    <a target="_blank" href="https://www.instagram.com/questmall/"><img style="width:34px;" src="'.base_url().'images/instragram_icon.png" alt="" class="img-fluid socialicon"></a></p>';
                    $message.='</div></body></html>';
                    $this->email->message($message);
                    $this->email->send();
                    $this->email->clear();

                    //// Mail For Admin ///////


                    $this->email->set_newline("\r\n");
                    $this->email->from('questmall1@gmail.com', 'Quest Trendsetter');
                    $this->email->to($emailForm);
                    $this->email->subject('Quest Trendsetter New Sign up');
                    $message = '<!DOCTYPE html><html><body style="margin:0">';
                    $message.='<div style="padding:0 50px; text-align:center;"><p align="left" style="font-family: Tahoma, Geneva, sans-serif; font-size:25px; color:#214c5b;">Dear <span> Admin</span></p>';
                    $message.='<p align="left" style="font-family: Tahoma, Geneva, sans-serif; font-size:16px; color:#000;">One New Sign up.</p>';

                    $message.='<table style="width:100%;text-align:left;" border="1"><tr><td>Name</td><td>'.$addArr['name'].'</td></tr><tr><td>Email</td><td>'.$addArr['email'].'</td></tr><tr><td>Phone</td><td>'.$addArr['phone'].'</td></tr><tr><td>Profession</td><td>'.$addArr['profession'].'</td></tr><tr><td>Category</td><td>'.($addArr['category'] == 'all'?'lifestyle,beauty,food,fitness,mother&child care,kids,movies':$addArr['category']).'</td></tr><tr><td>Experience</td><td>'.($addArr['experience'] == '1year'?'6 months - 1 year': ($addArr['experience'] == '2year'?'1 - 2 years': ($addArr['experience'] == '3year'?'2 - 3 years': ($addArr['experience'] == '4year'?'3 years or more':'')))).'</td></tr><tr><td>PREFERRED SOCIAL MEDIA PAGES</td><td>'.$addArr['preffered_social_media'].'</td></tr><tr><td>HOW OFTEN WOULD YOU LIKE TO CURATE CONTENT</td><td>'.$addArr['curate_content'].'</td></tr><tr><td>OTHER BRANDS THAT HE/SHE ARE CURRENTLY ENDORSING</td><td>'.$addArr['endorse_name'].'</td></tr><tr><td>LINKS TO HIS/HER SOCIAL HANDLES</td><td>'.$addArr['social_links'].'</td></tr><tr><td>HIS/HER MOST FASCINATING PIECE OF WORK</td><td>'.$addArr['facinating_piece'].'</td></tr><tr><td>About</td><td>'.$addArr['about'].'</td></tr><tr><td>Created</td><td>'.unix_to_human($addArr['created']).'</td></tr></table>';
                    $message.='<p align="left" style="font-family: Tahoma, Geneva, sans-serif; font-size:16px; color:#000;">Regards, <br> Quest Team</p>';
                    $message.='</div></body></html>';
                    $this->email->message($message);
                    $this->email->set_mailtype("html");
                    $this->email->send();

                    echo json_encode($arr);
            } else {
                $arr[] = array('type' => 'warning', 'msg' => validation_errors('<p class="text-danger">', '</p>'));
                echo json_encode($arr);
            }
        }
    }
}