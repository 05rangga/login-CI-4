<?php namespace App\Controllers;
use App\Libraries\Notification;
use CodeIgniter\Controller;

class Admin extends BaseController
{

protected $helpers = ['form','date'];
protected $session = null;
protected $request = null;

	public function __construct()
	{
$this->session = session();
$this->request = \Config\Services::request();
$this->notif = new Notification();
$this->moduser = model('App\Models\ModUsers');
	}


	public function index()
	{

if ($this->session->has('message')) {
	$dataIndex['message'] = $this->session->get('message');
} else {
	$dataIndex['message'] = "";
};

if (!isset($_SESSION['admin_logged_in'])) {
	$dataIndex['title'] = "Login - Administrator";
	$this->session->removeTempdata('message');
	return view('admin/login', $dataIndex);
}

        $dataIndex['title'] = "Dashboard";

        $dataIndex['header'] = view("admin/header");
    $dataIndex['sidebar'] = view("admin/sidebar");
       $dataIndex['menu'] = view("admin/menu");
       $dataIndex['footer'] = view("admin/footer");
        //$dataIndex['content'] = view("admin/content");
		return view('admin/index', $dataIndex);

	}


	public function login()
{
	$username = $this->request->getPost('username');
	$password = $this->request->getPost('password');

	if (isset($_SESSION['admin_logged_in'])) {
		return redirect()->to(base_url('admin'));
	}

	if (!isset($_SESSION['admin_logged_in']) && (empty($username) || empty($password))){
		$this->notif->message('Data login tidak lengkap', 'danger');
		return redirect()->to(base_url('admin'));
	}

	if (!isset($_SESSION['admin_logged_in']) && isset($username) && isset($password)) {
		$datauser = [
			'username' => $username,
			'password' => md5($password)
		];
		$user = $this->moduser->asObject()->where($datauser)->limit(1)->find();
		if (count($user) > 0) {
			if ($user[0]->active === 'N') {
				$this->notif->message('Akun anda tidak aktif', 'danger');
				return redirect()->to(base_url('admin'));
			} elseif ($user[0]->user_level !== '1') {
				$this->notif->message('Akun anda bukan Admin, dan tidak memiliki akses ke halaman ini', 'danger');
				return redirect()->to(base_url('admin'));
			} else {
				$data_session = array(
					'admin_user_id' => $user[0]->user_id,
					'admin_username' => $user[0]->username,
					'admin_level' => $user[0]->user_level,
					'admin_logged_in' => TRUE
				);
				$this->session->set($data_session);
				return redirect()->to(base_url('admin'));
			}
		} else {
			$this->notif->message('username atau password anda salah', 'danger');
			return redirect()->to(base_url('admin'));
		}
	}

}

public function logout(){
	$array_items = array('admin_user_id','admin_username','admin_level','admin_logged_in');
	$this->session->remove($array_items);
	return redirect()->to(base_url('admin'));
}

}