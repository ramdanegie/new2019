<?php
/**
 * Created by IntelliJ IDEA.
 * User: Egie Ramdan
 * Date: 23/02/2019
 * Time: 09.29
 */
namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class JenisProduk_M extends Model
{
	protected $table = 'jenisproduk_m';
	public $timestamps = false;
	public $incrementing = false;
	protected $primaryKey = 'id';
//	protected $fillable = [
//		'id',
//		'kdprofile',
//		'agama',
//		'reportdisplay',
//		'kodeexternal',
//		'namaexternal',
//		'statusenabled',
//		'norec'
//	];
	public static function queryTable($request){
		$table = 'jenisproduk_m';
		$param['table_from']= $table;
		$param['select']= array($table.'.*');
		$param['label'] = array();

		$param['where'][0]['fieldname']= $table.'.statusenabled';
		$param['where'][0]['operand']= '=';
		$param['where'][0]['is']= true;

		return $param;
	}
}