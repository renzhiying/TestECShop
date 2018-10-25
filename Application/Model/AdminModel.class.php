<?php
class AdminModel extends Model{
	public function check($data){
		//取得用户名和密码
		$adminName = $data["adminName"];
		$adminPwd = $data["adminPwd"];

		//构建条件
		$condition = "adminName='$adminName' and adminPwd='$adminPwd'";
		//调用父类方法
		// $fields="*";
		return $this->getRow($condition);
	}
	//写入Model  读取一条数据
	public function getOnce($id){
		return $this->getRowByPk($id);
	}
	
}


?>