<?php
namespace app\agent\model;
use app\agent\Auth;
class Agent extends Common {
	function __construct() {
		parent::init();
	}
	public function add($add) {
		$res = $this->con->select('menber',"username='{$add['username']}'");
		if($res) {
			exit(bx_msg('用户名已经存在','请更换用户名','error','alert'));
		}
		$res = $this->con->select('menber','id=' . Auth::get('id'),'','','','money,consumed,default_rate,default_money,manager_price,software_id');
		$self['money'] = $res['0']['money'] - $res['0']['manager_price'];
		$self['consumed'] = $res['0']['consumed'] + $res['0']['manager_price'];
		if( $self['money'] < '0.00' ) {
			exit(bx_msg('余额不足','请充值','error','alert'));
		}
		$add['money'] = $res['0']['default_money'];
		$add['rate'] = $res['0']['default_rate'];
		$add['software_id'] = $res['0']['software_id'];
		$add['power'] = '11';
		$add['salt'] = create_rand_str(6);
		$add['password'] = md5($add['password'] . $add['salt']);
		$add['boss_id'] = Auth::get('id');
		$add['regtime'] = time();
		$add['regip'] = get_ip();
		$this->con->update('menber',$self,'id=' . Auth::get('id'));
		$id = $this->con->insert('menber', $add,true);
		$this->con->insert('agent_authority', array('menber_id'=>$id));
		$this->log->menber('2',"添加代理:{$add['username']}, 密码:{$_POST['password']}, 余额:{$add['money']}, 个人余额:{$res['0']['money']} → {$self['money']}, 成功!",'2');
		exit(bx_msg('添加成功','恭喜您成功添加了一位代理','success'));
	}
	public function recharge($id,$money) {
		$res = $this->con->select('menber','id=' . Auth::get('id'),'','','','money,recharge_agent,consumed');
		$del = $money * $res['0']['recharge_agent']/100;
		$self['money'] = $res['0']['money'] - $del;
		if( $self['money'] < '0.00' ) {
			exit(bx_msg('余额不足','请充值','error'));
		}
		$self['consumed'] = $res['0']['consumed'] + $del;
		$this->con->update('menber',$self,'id=' . Auth::get('id'));
		$res1 = $this->con->select('menber',"id={$id}",'','','','money');
		$add['money'] = $res1['0']['money'] + $money;
		$this->con->update('menber',$add,"id={$id}");
		$this->log->menber('2',"充值代理(ID):{$id}, 余额:{$res1['0']['money']} → {$add['money']}, 个人余额:{$res['0']['money']} → {$self['money']}, 成功!",'2');
		exit(bx_msg("充值成功","成功充值{$money}元,扣除余额{$del}元",'success','alert'));
	}
	public function lists($where,$page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('menber',$where, 'LEFT JOIN pre_menber as a on pre_menber.boss_id = a.id', 'pre_menber.id',"{$pageset},{$limit}", 'pre_menber.id,pre_menber.username,pre_menber.power,pre_menber.money,pre_menber.consumed,pre_menber.congeal,
		pre_menber.comment,a.username as boss_name');
		empty($res) ? exit : FALSE;
		$conut = $this->con->select('menber',$where,'','','','COUNT(id)');
		echo bx_lists($res, $conut['0']['COUNT(id)']);
		exit;
	}
}
?>