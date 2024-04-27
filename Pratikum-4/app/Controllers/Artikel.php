<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->findAll();
        return view('artikel/index', ['artikel' => $artikel, 'title' => $title]);
    }

    public function view($slug)
    {
        $model = new ArtikelModel();
        $artikel = $model->where(['slug' => $slug])->first();
        // Menampilkan error apabila data tidak ada.
        if (!$artikel) {
            throw PageNotFoundException::forPageNotFound();
        }
        $title = $artikel['judul'];
        return view('artikel/detail', ['artikel' => $artikel, 'title' => $title]);
    }

    public function admin_index()
    {
        $title = 'Daftar Artikel';
        $q = $this->request->getVar('q') ?? '';
        $model = new ArtikelModel();
        $data = [
            'title' => $title,
            'q' => $q,
            'artikel' => $model->like('judul', $q)->paginate(2),
            'pager' => $model->pager,
        ];
        return view('artikel/admin_index', $data);
    }

    public function add()
    {
        // Validate data.
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required',
            'isi' => 'required',
        ]);

        // Run validation
        $isDataValid = $validation->withRequest($this->request)->run();

        if ($isDataValid) {
            // Data is valid, proceed with insertion
            $artikel = new ArtikelModel();
            $title = $this->request->getPost('judul');
            $isi = $this->request->getPost('isi');

            // Ensure title is a string and sanitize it
            $judul = is_string($title) ? $title : '';

            $insertData = [
                'judul' => $judul,
                'isi' => $isi,
                'slug' => url_title($judul, '-', TRUE), // Pass the sanitized title to url_title()
            ];

            // Insert into the database
            $success = $artikel->insert($insertData);

            if ($success) {
                // Redirect to article list page
                return redirect()->to('/admin/artikel');
            } else {
                // Handle insertion failure
                // You can display an error message or log the error
                return "Failed to insert article!";
            }
        }

        // If validation fails, render the form again with validation errors
        $title = "Tambah Artikel";
        $errors = $validation->getErrors(); // Get validation errors
        return view('artikel/add', ['title' => $title, 'errors' => $errors]);
    }

    public function edit($id)
    {
        $artikel = new ArtikelModel();
        // validasi data.
        $validation = \Config\Services::validation();
        $validation->setRules(['judul' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();
        if ($isDataValid) {
            $artikel->update($id, [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
            ]);
            return redirect('admin/artikel');
        }
        // ambil data lama
        $data = $artikel->where('id', $id)->first();
        $title = "Edit Artikel";
        return view('artikel/edit', compact('title', 'data'));
    }

    public function delete($id)
    {
        $artikel = new ArtikelModel();
        $artikel->delete($id);
        return redirect('admin/artikel');
    }
}
