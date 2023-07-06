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
        $user = User::all();
        $this->_createView('form', ['user_list' => $user]);
    }

    public function simpan()
    {
        
        if ($this->input->post()){
            $user_id = $this->input->post('user_id');
            $article = $this->input->post('article');
            $jenis = $this->input->post('radio');
            
            $post = new Post();
    
            $post->user_id = $user_id;
            $post->article = $article;
            $post->jenis = $jenis;
            $post->save();
        }

        redirect('Welcome/index');
    }

    public function hapus($id)
    {
        $del = Post::find($id);
        $del->delete();
        
        redirect('Welcome/tampil');
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $users = User::all();

        $jenis = 0;
        if($post->jenis == 'Berita') $jenis = 0;
        else if($post->jenis == 'Tutorial') $jenis = 1;
        else if($post->jenis == 'Blog') $jenis = 2;

        $this->_createView('update', ['post' => $post, 'users' => $users, 'jenis' => $jenis]);
    }

    public function update($id)
    {
        $post = Post::find($id);
        $post->user_id = $this->input->post('user_id');
        $post->article = $this->input->post('article');
        $post->jenis = $this->input->post('radio');

        $post->save();

        redirect('Welcome/tampil');
    }


    public function tampil()
    {
        $post_list = Post::all();

        $this->_createView('tampil', ['post_list' => $post_list]);
    }
}