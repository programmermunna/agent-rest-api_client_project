<?php

/************************************
*by Raymond Ginting 8 October 2020
************************************/

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\BcaAccountModel;

use DOMDocument;

use App\Models\Settings;
use Carbon\Carbon;

define('BCA_PARSER_DEBUG', false);

class BcaHelper {
    
    /*********************************************************
     * Used on Bca Account
     *********************************************************/
    public static function userid($currBankAccountId) {
        $userBca = BcaAccountModel::where('id',$currBankAccountId)->value('userbca');
        return $userBca;
	}
    
    public static function password($currBankAccountId) {
        $passwordBca = BcaAccountModel::where('id',$currBankAccountId)->value('password');
        return $passwordBca;
	}
    
    /*********************************************************
     * BCA Parser
     *********************************************************/
    private $username;
	private $password;
	private $post_time;
	
	protected $curlHandle;

	public $_defaultTargets = [
		'loginUrl' => 'https://m.klikbca.com/login.jsp',
		'loginAction' => 'https://m.klikbca.com/authentication.do',
		'logoutAction' => 'https://m.klikbca.com/authentication.do?value(actions)=logout',
		'cekSaldoUrl' => 'https://m.klikbca.com/balanceinquiry.do'
	];
	protected $isLoggedIn = false;
	
	protected $ipAddress;
	
	public $_defaultHeaders = array(
		'GET /login.jsp HTTP/1.1',
		'Host: m.klikbca.com',
		'Connection: keep-alive',
		'Cache-Control: max-age=0',
		'Upgrade-Insecure-Requests: 1',
		'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.76 Mobile Safari/537.36',
		'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
		'Accept-Encoding: gzip, deflate, sdch, br',
		'Accept-Language: en-US,en;q=0.8,id;q=0.6,fr;q=0.4'
	);
	
	/**
	* The Constructor
	* this class will make login request to BCA when initialized
	*
	* @param string $username
	* @param string $password
	*/
	public function __construct($username, $password)
	{
		if( BCA_PARSER_DEBUG == true ) error_reporting(E_ALL);
		$this->username = $username;
		$this->password = $password;
		$this->curlHandle = curl_init();
		$this->setupCurl();
		$this->login($this->username, $this->password);

		# duration date to get mutation
		$settings = Settings::findorfail(1);
		$hari = $settings->duration;

		$timeconstruct = time();//+ ( 3600 * 14 );
		$d          = explode( '|', date( 'Y|m|d|H|i|s', $timeconstruct ) );
        $start      = mktime( $d[3], $d[4], $d[5], $d[1], ( $d[2] - $hari ), $d[0] );
        $this->post_time['end']['y'] = $d[0];
        $this->post_time['end']['m'] = $d[1];
        $this->post_time['end']['d'] = $d[2];
        $this->post_time['start']['y'] = date( 'Y', $start );
        $this->post_time['start']['m'] = date( 'm', $start );
        $this->post_time['start']['d'] = date( 'd', $start );
	}
	
	/**
	* Get ip address, required on login parameters
	*
	* @return String;
	*/
	private function getIpAddress()
	{
		if($this->ipAddress !== null) $this->ipAddress = json_decode( file_get_contents( 'http://myjsonip.appspot.com/' ) )->ip;
		return $this->ipAddress;
	}
	
	/**
	* Execute the CURL and return result
	*
	* @return curl result
	*/
	public function exec()
	{
		$result = curl_exec($this->curlHandle);
		if( BCA_PARSER_DEBUG == true ) {
			$http_code = curl_getinfo($this->curlHandle, CURLINFO_HTTP_CODE);
			print_r($result);

			/**
			* Perlu diwapadai jangan melakukan pengecekan dengan interval waktu dibawah 10 menit ! 
			*/
			if($http_code == 302) {
				echo 'HALAMAN DIREDIRECT, harap tunggu beberapa menit ( biasanya 10 Menit! )';
				exit;
			}

		}
		return $result;
	}
	
	/**
	* Register default CURL parameters
	*/
	protected function setupCurl()
	{
		curl_setopt( $this->curlHandle, CURLOPT_URL, $this->_defaultTargets['loginUrl'] );
		curl_setopt( $this->curlHandle, CURLOPT_POST, 0 );
		curl_setopt( $this->curlHandle, CURLOPT_HTTPGET, 1 );
		curl_setopt( $this->curlHandle, CURLOPT_HTTPHEADER, $this->_defaultHeaders);
		curl_setopt( $this->curlHandle, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $this->curlHandle, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $this->curlHandle, CURLOPT_COOKIEFILE,'cookie' );
		curl_setopt( $this->curlHandle, CURLOPT_COOKIEJAR, 'cookiejar' );
	}
	
	/**
	* Set request method on CURL to GET 
	*/
	protected function curlSetGet()
	{
		curl_setopt( $this->curlHandle, CURLOPT_POST, 0 );
		curl_setopt( $this->curlHandle, CURLOPT_HTTPGET, 1 );
	}
	
	/**
	* Set request method on CURL to POST 
	*/
	protected function curlSetPost()
	{
		curl_setopt( $this->curlHandle, CURLOPT_POST, 1 );
		curl_setopt( $this->curlHandle, CURLOPT_HTTPGET, 0 );
	}
	
	/**
	* Login to BCA
	*/
	private function login($username, $password)
	{
		//Just to Get Cookies
		curl_setopt( $this->curlHandle, CURLOPT_URL, $this->_defaultTargets['loginUrl'] );
		$this->curlSetGet();
		$this->exec();
		
		//Sending Login Info
		$this->getIpAddress();
		$params = array(
			"value(user_id)={$username}",
			"value(pswd)={$password}",
			'value(Submit)=LOGIN',
			'value(actions)=login',
			"value(user_ip)={$this->ipAddress}",
			"user_ip={$this->ipAddress}",
			'value(mobile)=true',
			'mobile=true'
		);
		$params = implode( '&', $params );
		$this->curlSetPost();
		curl_setopt( $this->curlHandle, CURLOPT_URL, $this->_defaultTargets['loginAction'] );
		curl_setopt( $this->curlHandle, CURLOPT_REFERER, $this->_defaultTargets['loginUrl'] );
		curl_setopt( $this->curlHandle, CURLOPT_POSTFIELDS, $params );
		$this->exec();
		$this->isLoggedIn = true;
	}

	/**
	 * Get saldo rekening pages
	 *
	 * @return string
	 */
	public function getSaldo()
	{
		if( !$this->isLoggedIn ) $this->login( $this->username, $this->password );
		$this->curlSetPost();
		curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=menu' );
        curl_setopt( $this->curlHandle, CURLOPT_REFERER, $this->_defaultTargets['loginAction'] );
        $this->exec();
        curl_setopt( $this->curlHandle, CURLOPT_URL, $this->_defaultTargets['cekSaldoUrl'] );
        curl_setopt( $this->curlHandle, CURLOPT_REFERER, 'https://m.klikbca.com/accountstmt.do?value(actions)=menu' );
        $src = $this->exec();

        $parse = explode( "<td align='right'><font size='1' color='#0000a7'><b>", $src );
        if ( empty( $parse[1] ) )
            return false;
        $parse = explode( '</td>', $parse[1] );
        
		if ( empty( $parse[0] ) )
            return false;
        $parse = str_replace( ',', '', $parse[0] );
        return ( is_numeric( $parse ) )? $parse: false;
	}

	/**
	 * Get nomor rekening
	 *
	 * @return string
	 */
	public function getNomorRekening()
	{
		if( !$this->isLoggedIn ) $this->login( $this->username, $this->password );
		$this->curlSetPost();
		curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=menu' );
        curl_setopt( $this->curlHandle, CURLOPT_REFERER, $this->_defaultTargets['loginAction'] );
        $this->exec();
        curl_setopt( $this->curlHandle, CURLOPT_URL, $this->_defaultTargets['cekSaldoUrl'] );
        curl_setopt( $this->curlHandle, CURLOPT_REFERER, 'https://m.klikbca.com/accountstmt.do?value(actions)=menu' );
        $src = $this->exec();

        $parse = explode( "<td><font size='1' color='#0000a7'><b>", $src );
        if ( empty( $parse[1] ) )
            return false;
		$parse = explode( '</td>', $parse[1] );
		
		if ( empty( $parse[0] ) )
            return false;
        $parse = $parse[0];
        return (  $parse  )? $parse: false;
	}
	
 	/**
	* Parse the pages on saldo rekening
	* this method will return only elements on <table> tag that contain only rekening and its saldo
	*
	* @param string $html
	* @return string
	*/
	private function getSaldoRekeningTable($html)
	{
		$dom = new DOMDocument();
	
		if ( BCA_PARSER_DEBUG ) {
			$dom->loadHTML($html);	
		} else {
			@$dom->loadHTML($html);	
		}
		
		$dom->getElementById('pagebody');
		
		$table = $dom->getElementsByTagName('table');
		$table = $table->item(3);
		return $dom->saveHTML($table);
	}

 	/**
	 * Get array value from data saldo page
	 * 
	 * @param  string $html
	 * @return array 
	 *  {
	 *     {'rekening'=>'norek1', 'saldo'=>'100.000'},
	 *     {'rekening'=>'norek2', 'saldo'=>'100.000'}
	 *  }
	 */
	private function getArrayValuesSaldo($html)
	{
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		$table = $dom->getElementsByTagName('table');
		$rows = $dom->getElementsByTagName('tr');
 		$datas = [];
		for ($i = 0; $i < $rows->length; $i++) {
			if($i == 0) continue; // skip head
		    
		    $cols = $rows->item($i)->getElementsbyTagName("td");
 		    $rekening = $cols->item(0)->nodeValue;
		    $saldo = $cols->item(2)->nodeValue;
 		    $data = compact('rekening','saldo');
		    $datas[] = $data;
		}
		return $datas;
	}
	
	/**
	* Get mutasi rekening pages
	*
	* @param string $from 'Y-m-d'
	* @param string $to 'Y-m-d'
	* @return string
	*/
	public function getMutasiRekening($from, $to)
	{
		if( !$this->isLoggedIn ) $this->login( $this->username, $this->password );
		
		$this->curlSetPost();
		
		curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=menu' );
		curl_setopt( $this->curlHandle, CURLOPT_REFERER, $this->_defaultTargets['loginAction'] );
		$this->exec();

		curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=acct_stmt' );
		curl_setopt( $this->curlHandle, CURLOPT_REFERER, 'https://m.klikbca.com/accountstmt.do?value(actions)=menu' );
		$this->exec();
		
		$params = array( 
				'r1=1', 
				'value(D1)=0', 
				'value(startDt)=' . date( 'j', strtotime($from) ), 
				'value(startMt)=' . date( 'n', strtotime($from) ), 
				'value(startYr)=' . date( 'Y', strtotime($from) ),
				'value(endDt)=' . date( 'j', strtotime($to) ),
				'value(endMt)=' . date( 'n', strtotime($to) ), 
				'value(endYr)=' . date( 'Y', strtotime($to) ) 
				);
		$params = implode( '&', $params );
		
		curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=acctstmtview' );
		curl_setopt( $this->curlHandle, CURLOPT_REFERER, 'https://m.klikbca.com/accountstmt.do?value(actions)=acct_stmt' );
		curl_setopt( $this->curlHandle, CURLOPT_POSTFIELDS, $params );
		$html = $this->exec();

		return $this->getMutasiRekeningTable($html);
	}
	
	/**
	* Parse the pages on mutasi rekening
	* this method will return only elements on <table> tag that contain only list of transaction
	*
	* @param string $html
	* @return string
	*/
	private function getMutasiRekeningTable($html)
	{
		$dom = new DOMDocument();
	
		if ( BCA_PARSER_DEBUG ) {
			$dom->loadHTML($html);	
		} else {
			@$dom->loadHTML($html);	
		}
		
		$dom->getElementById('pagebody');
		
		$table = $dom->getElementsByTagName('table');
		$table = $table->item(4);
		return $dom->saveHTML($table);
	}

	/**
	 * Get Array Values from an HTML <table> element
	 *
	 * @param string $html
	 * @return array
	 */
	private function getArrayValues($html)
	{
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		$table = $dom->getElementsByTagName('table');
		$rows = $dom->getElementsByTagName('tr');

		$datas = [];
		for ($i = 0; $i < $rows->length; $i++) {
			if($i== 0 ) continue;
		    $cols = $rows->item($i)->getElementsbyTagName("td");

			// PEND menunjukkan transaksi telah berhasil dilakukan namun belum dibukukan oleh pihak BCA
			// https://twitter.com/HaloBCA/status/993661368724156416
		    $date = trim( $cols->item(0)->nodeValue );
			if ( $date != 'PEND' ) {
				$date = explode('/', $date);
				$date = date('Y') . '-' . $date[1] . '-' . $date[0];
			}
		    
		    $description = $cols->item(1);
		    $flows = trim( $cols->item(2)->nodeValue );
		    $descriptionText = $dom->saveHTML($description);

		    $descriptionText = str_replace('<td>', '', $descriptionText);
		    $descriptionText = str_replace('</td>', '', $descriptionText);
		    $description = explode('<br>', $descriptionText);
			
			// Trim array Values
			if ( is_array( $description ) ) {
				$description = array_map('trim', $description);
			}
			
		    $data = compact('date','description', 'flows');
		    $datas[] = $data;
		}
		
		return $datas;
	}

	/*
	 * Get saldo awal
	 * 28 nov 2020 - Raymond Ginting
	*/
	public function getSaldoAwal($from, $to)
	{
		if( !$this->isLoggedIn ) $this->login( $this->username, $this->password );
		$this->curlSetPost();
		
		curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=menu' );
		curl_setopt( $this->curlHandle, CURLOPT_REFERER, $this->_defaultTargets['loginAction'] );
		$this->exec();

		curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=acct_stmt' );
		curl_setopt( $this->curlHandle, CURLOPT_REFERER, 'https://m.klikbca.com/accountstmt.do?value(actions)=menu' );
		$this->exec();
		
		$params = array( 
				'r1=1', 
				'value(D1)=0', 
				'value(startDt)=' . date( 'j', strtotime($from) ), 
				'value(startMt)=' . date( 'n', strtotime($from) ), 
				'value(startYr)=' . date( 'Y', strtotime($from) ),
				'value(endDt)=' . date( 'j', strtotime($to) ),
				'value(endMt)=' . date( 'n', strtotime($to) ), 
				'value(endYr)=' . date( 'Y', strtotime($to) ) 
				);
		$params = implode( '&', $params );
		
		curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=acctstmtview' );
		curl_setopt( $this->curlHandle, CURLOPT_REFERER, 'https://m.klikbca.com/accountstmt.do?value(actions)=acct_stmt' );
		curl_setopt( $this->curlHandle, CURLOPT_POSTFIELDS, $params );
		$html = $this->exec();

		$parse = explode( '<td align="left">', $html );
		
		if ( empty( $parse[5] ) )
            return false;
        $parse = explode( '</td>', $parse[5] );
		if ( empty( $parse[0] ) )
            return false;
		$parse = str_replace( ',', '', $parse[0] );
		
        return ( is_numeric( $parse ) )? $parse: false;
	}

	
	####################################################################################################
	public function testParser($from, $to)
	{
		if( !$this->isLoggedIn ) $this->login( $this->username, $this->password );
		$this->curlSetPost();
		
		curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=acct_stmt' );
        curl_setopt( $this->curlHandle, CURLOPT_REFERER, 'https://m.klikbca.com/accountstmt.do?value(actions)=menu' );
        $this->exec();

        // $inputs = array(
        // 	'r1=1',
        // 	'value(D1)=0',
        // 	'value(startDt)='.$this->post_time['start']['d'],
        // 	'value(startMt)='.$this->post_time['start']['m'],
        // 	'value(startYr)='.$this->post_time['start']['y'],
        // 	'value(endDt)='.$this->post_time['end']['d'],
        // 	'value(endMt)='.$this->post_time['end']['m'],
        // 	'value(endYr)='.$this->post_time['end']['y']
		// );
		
		$inputs = array( 
			'r1=1', 
			'value(D1)=0', 
			'value(startDt)=' . date( 'j', strtotime($from) ), 
			'value(startMt)=' . date( 'n', strtotime($from) ), 
			'value(startYr)=' . date( 'Y', strtotime($from) ),
			'value(endDt)=' . date( 'j', strtotime($to) ),
			'value(endMt)=' . date( 'n', strtotime($to) ), 
			'value(endYr)=' . date( 'Y', strtotime($to) ) 
		);

        $params = implode('&', $inputs);

        curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=acctstmtview' );
        curl_setopt( $this->curlHandle, CURLOPT_REFERER, 'https://m.klikbca.com/accountstmt.do?value(actions)=acct_stmt' );
        curl_setopt( $this->curlHandle, CURLOPT_POSTFIELDS, $params );
        curl_setopt( $this->curlHandle, CURLOPT_POST, 1 );

        $src = $this->exec(); dump($src);
        // return $src;
        $parse = explode( '<table border="1" width="100%" cellpadding="0" cellspacing="0" bordercolor="#ffffff">', $src );

        if (empty($parse[1])) return false;

        $parse = explode('</table>', $parse[1]);
        $parse = explode('<tr>', $parse[0]);
        $rows  = array(); 
        foreach ($parse as $n => $r) {
            if ($n > 1) {
                $r = explode('</tr>', $r);
                $rows[] = $r[0];
            }
        }

        foreach ($rows as $k => $val) {
            $rows[$k]   = new stdClass;
            $parse      = explode('<font face="verdana" size="1" color="#0000bb">', $val);
            $date       = explode('</font>', $parse[1]);
            $date       = trim($date[0]);
            if ($date != 'PEND') {
                $date = str_replace('/', '-', $date.'/'.date('Y'));
                $date = date('Y-m-d', strtotime($date));
            }
            $desc       = explode('</font>', $parse[2]);
            $desc       = preg_replace('/\s+/', ' ', trim(strip_tags($desc[0])));
            $amount     = explode('</font>', $parse[4]);
            $amount     = str_replace(',', '', trim($amount[0]));
            $type       = explode('</font>', $parse[5]);
            $type       = trim($type[0]);
            if ($type == 'DB') {
                $debet  = $amount;
                $kredit = '0.00';
            } else {
                $debet  = '0.00';
                $kredit = $amount;
            }

            $rows[$k]->date         = $date;
            $rows[$k]->description  = $desc;
            $rows[$k]->debet        = $debet;
            $rows[$k]->kredit       = $kredit;
        }
        
        return (!empty($rows)) ? $rows : false;
	}
	####################################################################################################

	/**
	* Ambil daftar transaksi pada janga waktu tertentu
	*
	*
	* @param string $from 'Y-m-d'
	* @param string $to 'Y-m-d'
	* @return array
	**/
	public function getListTransaksi($from, $to)
	{
		// $result = $this->getMutasiRekening($from, $to);
		// $result = $this->getArrayValues($result);
		// return $result;

		if( !$this->isLoggedIn ) $this->login( $this->username, $this->password );
		$this->curlSetPost();
		curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=menu' );
        curl_setopt( $this->curlHandle, CURLOPT_REFERER, $this->_defaultTargets['loginAction'] );
        $this->exec();
        curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=acct_stmt' );
        curl_setopt( $this->curlHandle, CURLOPT_REFERER, 'https://m.klikbca.com/accountstmt.do?value(actions)=menu' );
		$this->exec();
		
        // $params = implode( '&', array( 'r1=1', 'value(D1)=0', 'value(startDt)=' . $this->post_time['start']['d'], 'value(startMt)=' . $this->post_time['start']['m'], 'value(startYr)=' . $this->post_time['start']['y'],'value(endDt)=' . $this->post_time['end']['d'], 'value(endMt)=' . $this->post_time['end']['m'], 'value(endYr)=' . $this->post_time['end']['y'] ) );
		$params = array( 
				'r1=1', 
				'value(D1)=0', 
				'value(startDt)=' . date( 'j', strtotime($from) ), 
				'value(startMt)=' . date( 'n', strtotime($from) ), 
				'value(startYr)=' . date( 'Y', strtotime($from) ),
				'value(endDt)=' . date( 'j', strtotime($to) ),
				'value(endMt)=' . date( 'n', strtotime($to) ), 
				'value(endYr)=' . date( 'Y', strtotime($to) ) 
				);
		$params = implode( '&', $params );

		##### parse saldo ##############################################
		// curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=acctstmtview' );
		// curl_setopt( $this->curlHandle, CURLOPT_REFERER, 'https://m.klikbca.com/accountstmt.do?value(actions)=acct_stmt' );
		// curl_setopt( $this->curlHandle, CURLOPT_POSTFIELDS, $params );
		// $html = $this->exec();
		// $parseSaldo = explode( '<td align="left">', $html );
		
		// if ( empty( $parseSaldo[5] ) )
        //     return false;
        // $parseSaldo = explode( '</td>', $parseSaldo[5] );
		// if ( empty( $parseSaldo[0] ) )
        //     return false;
		// $parseSaldo = str_replace( ',', '', $parseSaldo[0] );
		##### parse saldo ###############################################

        curl_setopt( $this->curlHandle, CURLOPT_URL, 'https://m.klikbca.com/accountstmt.do?value(actions)=acctstmtview' );
        curl_setopt( $this->curlHandle, CURLOPT_REFERER, 'https://m.klikbca.com/accountstmt.do?value(actions)=acct_stmt' );
        curl_setopt( $this->curlHandle, CURLOPT_POSTFIELDS, $params );
        curl_setopt( $this->curlHandle, CURLOPT_POST, 1 );

		$src = $this->exec();

        $parse = explode( '<table width="100%" class="blue">', $src ); 
        if ( empty( $parse[1] ) )
            return false;
        $parse = explode( '</table>', $parse[1] );
        $parse = explode( '<tr', $parse[0] );
        $rows = array();
		
        foreach( $parse as $val )
            if ( substr( $val, 0, 8 ) == ' bgcolor' )
                $rows[] = $val;
		
        foreach( $rows as $key => $val )
        {
			$rows[$key]     = explode( '</td>', $val );
			$tglTransaksiDMSlash = substr( $rows[$key][0], -5 ).'/'.$this->post_time['start']['y'];
			$tglTransaksiDMStrip = str_replace('/', '-', $tglTransaksiDMSlash);
			
			# Tanggal Transaksi
            if ( stristr( $rows[$key][0], 'pend' ) ){
                # hari ini
				$rows[$key][0] = Carbon::now()->format('Y-m-d');
			}else{
				# tgl apa adanya yg ada di bca sana.
				$rows[$key][0]  = Carbon::parse($tglTransaksiDMStrip)->format('Y-m-d');
			}
            $detail         = explode( "<td valign='top'>", $rows[$key][1] ); 
			# Keterangan
			$rows[$key][2]  = $detail[1];
			# Jenis Transaksi
			$rows[$key][1]  = explode( '<br>', $detail[0] );
			# Nominal Uang
			$rows[$key][3]  = str_replace( ',', '', $rows[$key][1][count($rows[$key][1])-1] );

			

			unset( $rows[$key][1][count($rows[$key][1])-1] );
            foreach( $rows[$key][1] as $k => $v )
                $rows[$key][1][$k] = trim( strip_tags( $v ) );
			$rows[$key][1] = implode( " ", $rows[$key][1] );
       }
	   
        return ( !empty( $rows ) )? $rows: false;
	}

	/**
	* getTransaksiCredit
	*
	* Ambil semua list transaksi credit (kas Masuk)
	*
	* @param string $from 'Y-m-d'
	* @param string $to 'Y-m-d'
	* @return array
	*/
	public function getTransaksiCredit($from, $to)
	{
		$result = $this->getListTransaksi($from, $to);
		$result = array_filter($result, function($row){
			return $row['flows'] == 'CR';
		});
		return $result;
	}

	/**
	* getTransaksiDebit
	*
	* Ambil semua list transaksi debit (kas Keluar)
	* Struktur data tidak konsisten !, tergantung dari jenis transaksi
	*
	* @param string $from 'Y-m-d'
	* @param string $to 'Y-m-d'
	* @return array
	*/
	public function getTransaksiDebit($from, $to)
	{
		$result = $this->getListTransaksi($from, $to);
		$result = array_filter($result, function($row){
			return $row['flows'] == 'DB';
		});
		return $result;
	}

	/**
	* Logout
	* 
	* Logout from KlikBca website
	* Lakukan logout setiap transaksi berakhir!
	*
	* @return string
	*/
	public function logout()
	{
		$this->curlSetGet();
		curl_setopt( $this->curlHandle, CURLOPT_URL, $this->_defaultTargets['logoutAction'] );
		curl_setopt( $this->curlHandle, CURLOPT_REFERER, $this->_defaultTargets['loginUrl'] );
		// return $this->exec();
		$this->exec();
		return curl_close( $this->curlHandle );
	}
    
}