<?php
class bv39v_data_htmltable extends bv39v_action {
	public function render($name,$columns,$data)
	{
		$return = "";
		$this->view->columns = $columns;
		$this->view->name = $name;
		$this->view->data = $data;
		$return .= $this->render_script ( 'htmltable/header.phtml' );
		$return .= $this->render_script ( 'htmltable/body.phtml' );
		$return .= $this->render_script ( 'htmltable/footer.phtml' );
		return $return;
	}
}