<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;

class MyController extends BaseController
{

    /**
     * @var \CodeIgniter\Model
     * Model of this controller
     */
    protected $model;

    /**
     * @var string
     * Folder of view
     */
    protected $viewFolder;

    /**
     * @var array
     * Data to be passed to view 
     * must contain title, subtitle, url, primary_key
     */
    protected $data;



    /**
     * @var array
     * Fields of table
     */
    protected $fields;

    function __construct()
    {
        $query = new $this->model;
        $this->datatable = $query->select(implode(',', array_keys($this->fields)));
    }

    protected function generateActionTable($actions)
    {
        $html = '<div class="btn-group-horizontal">';
        foreach ($actions as $action) {
            if (is_array($action['url'])) {
                $can_perform = true;
                $data = [];
                foreach ($action['url'] as $key => $value) {
                    if (!$value) {
                        $can_perform = false;
                        break;
                    }
                    $data[] = "data-url-{$key}={$action['url'][$key]}";
                }

                if (!$can_perform) {
                    continue;
                }

                $data = implode(' ', $data);
                $html .= "<button {$data} class='{$action['class']}'><i class='{$action['icon']}'></i></button>";
            } else {
                if ($action['url']) {
                    $data = "data-url={$action['url']}";
                    $html .= "<button {$data} class='{$action['class']}'><i class='{$action['icon']}'></i></button>";
                }
            }
        }
        $html .= '</div>';

        return $html;
    }

    protected function prepareDataTable($datatable)
    {
        return $datatable;
    }

    protected function prepareDataStore($data)
    {
        return $data;
    }

    protected function prepareDataUpdate($data)
    {
        return $data;
    }

    protected function prepareDataShow($data)
    {
        return $data;
    }

    protected function beforeIndex($data)
    {
        return $data;
    }

    protected function beforeShow($data)
    {
        return $data;
    }
    public function datatable()
    {
        $datatable = DataTable::of($this->datatable)->addNumbering();

        $datatable = $this->prepareDataTable($datatable);

        return $datatable->toJson();
    }

    public function index()
    {
        $data = $this->data;
        $data['viewFolder'] = $this->viewFolder;
        $data['fields'] = $this->fields;

        $data = $this->beforeIndex($data);
        return view($this->viewFolder . 'index', $data);
    }

    public function show($id)
    {
        $model = new $this->model;
        $data = $model->find($id);

        // get content type from header
        $accept = $this->request->getHeaderLine('accept');
        $isJson = strpos($accept, 'application/json') !== false;

        if (!$data) {
            if ($isJson) {
                // response code 404
                $this->response->setStatusCode(404);
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data not found'
                ]);
            } else {
                $this->response->setStatusCode(404);
                return view('errors/html/error_404');
            }
        }


        $data = $this->prepareDataShow($data);

        if ($isJson) {
            return $this->response->setJSON($data);
        } else {
            $data = array_merge($this->data, [
                'data' => $data,
            ]);

            $data = $this->beforeShow($data);

            return view($this->viewFolder . 'show', $data);
        }
    }

    public function store()
    {
        $model = new $this->model;
        foreach (array_keys($model->scenario()['store']) as $field) {
            $data[$field] = $this->request->getPost($field);
        }

        $data = $this->prepareDataStore($data);

        try {
            if ($model->insert($data)) {
                return json_encode(['status' => true, 'message' => 'Data berhasil disimpan']);
            } else {
                $errors = $model->errors();
                return json_encode(['status' => false, 'message' => isset($errors) ? array_shift($errors) : 'Data gagal disimpan']);
            }
        } catch (\Exception $e) {
            $msg = $e->getMessage() ?? 'Data gagal disimpan';
            return json_encode(['status' => false, 'message' => $msg]);
        }
    }

    public function update($id)
    {
        $model = new $this->model;
        $existing = $model->find($id);
        if (!$existing) {
            // header code 404
            $this->response->setStatusCode(404);

            // return 404 page
            return $this->respnose->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }


        $data = [];
        $request = $this->request->getRawInput();
        foreach (array_keys($model->scenario()['update']) as $field) {
            if (isset($request[$field])) {
                $data[$field] = $request[$field];
            }
        }

        // add primary key to data
        $data[$model->primaryKey] = $id;

        $data = $this->prepareDataUpdate($data);
        try {
            if ($model->update($id, $data)) {
                // return json
                return json_encode([
                    'status' => true,
                    'message' => 'Data berhasil diubah',
                ]);
            } else {
                // get first error
                $errors = $model->errors();
                return json_encode([
                    'status' => false,
                    'message' => isset($errors) ? array_shift($errors) : 'Data gagal diubah',
                ]);
            }
        } catch (\Throwable $th) {
            $msg = "";
            // if development mode, show error message
            if (ENVIRONMENT == 'development') {
                $msg = $th->getMessage();
            } else {
                $msg = "Data gagal diubah";
            }

            return json_encode([
                'status' => false,
                'message' => $msg,
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $model = new $this->model;
            if ($model->delete($id)) {
                return json_encode(['status' => true, 'message' => 'Data berhasil dihapus']);
            } else {
                // get first error
                $errors = $model->errors();
                return json_encode([
                    'status' => false,
                    'message' => isset($errors) ? array_shift($errors) : 'Data gagal dihapus',
                ]);
            }
        } catch (\Exception $e) {
            $msg = "";
            // if development mode, show error message
            if (ENVIRONMENT == 'development') {
                $msg = $e->getMessage();
            } else {
                $msg = "Data gagal diubah";
            }

            return json_encode(['status' => false, 'message' => $msg]);
        }
    }
}
