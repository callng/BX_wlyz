<?php
namespace app\index\controller;
class Index {
	public function index() {
		echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>阿柒_Bot</title></head><style type="text/css"> *{ padding: 0; margin: 0;} h1{ font-family: "Microsoft yahei"; font-size: 100px; font-weight: normal; margin-bottom: 12px; color: #333;}</style><body><div style="padding: 24px 48px;"><h1>^_^</h1><h1 style="font-size:42px">阿柒_Bot V' . APP_VERSION . '</h1></div></body></html>';
	}
}
?>