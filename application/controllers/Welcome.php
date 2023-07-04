<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Jenssegers\Blade\Blade;
use Orm\Post;
use Orm\User;

class Welcome extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/userguide3/general/urls.html
     */
    private $_blade;

    // create construct
    public function __construct()
    {
        parent::__construct();
        $this->_blade = new Blade(VIEWPATH, APPPATH . 'cache');
    }

    private function _createView($view, $data)
    {
        echo $this->_blade->make($view, $data)->render();
    }

    public function index()
    {
       $avail_user = User::all();
       $this->_createView('from', ['avail_user'=>$avail_user]);
    }

    public function simpan()
    {
        
        $username = $this->input->post('username');
        $article = $this->input->post('artikel');
        
        $post = new Post();
        $post->user_id = $username;
        $post->article = $artikel;
        $post->save();
        
        redirect('Welcome/tampil');

        $this->_createView('tampil', []);
    }

    public function hapus()
    {
        $post = Post::find($id);
        
        $post->delete();

        redirect ('welcome/tampil');
    }

    public function ubah()
    {
        $post = Post::find($id);
        $post->user_id = $this->input->post('username');
        $post->artikel = $this->inout->post('artikel');
        $post->save();

        redirect('welcome/tampil');
    }

    public function tampil()
    {
        $post_list = Post::all();
        $this->_createView('tampil', ['post_list' => $post_list]);
}
}