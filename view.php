<?php
class View {
    protected $model;
    protected $data;

    public function __construct($model) {
        $this->model = $model;
    }

    public function render() {
        $global_data = array(
            'site_title' => 'Hobby - Modelarstwo - Darek Stojaczyk',
            'site_header' => 'Moje hobby - Modelarstwo',
            'cur_page' => $this->model->getName()
        );
        extract($global_data);

        if (isset($this->data)) {
            extract($this->data);
        }
        require_once("view/tpl/{$this->model->getTemplate()}.php");
    }
}