<?php
class ControllerModuleEvotor extends Controller {
	private $error = array();
	private $pname = 'evotor';
	private $extcl = 'module';
	private $extfolder = 'module';
	private $ver = '7.0.0(oc1.5)';

	public function index() {
		
    	function _1874990685($i){$a=Array('d' .'mVy' .'c2l' .'vbg=' .'=','a' .'GQ=','b' .'2tmb3JtYXQ=','Y' .'mN0aGVh' .'dmhmeHh' .'4dm9' .'yZQ==','d' .'X' .'V' .'hZ2x6','SFRUU' .'F9' .'IT1NU','Lw==','aGV' .'hZGluZ' .'190aXRsZQ==','' .'Z3N' .'k','c' .'2' .'V0dGluZy9zZ' .'XR' .'0aW5' .'n','eG' .'4=','Yw==','U' .'kV' .'RV' .'U' .'VTVF9NRV' .'RIT0' .'Q=','UE9TVA=' .'=','SFRUU' .'F9' .'I' .'T' .'1NU','d' .'3d3Lg' .'==','ZVZ' .'vZ' .'nI=','' .'ZVZv' .'Z' .'n' .'I' .'=','SFRUUF9' .'IT1N' .'U','' .'d3d3Lg' .'=' .'=','' .'a' .'Gh2' .'Ym9kd' .'m14ZWt0Zg==','b3o' .'=','Z' .'GRlaHh2c' .'WV' .'zaGFlY2' .'h' .'w' .'dmZv','' .'aXo=','X2xpY2Vuc2U=','c' .'2V' .'0' .'dGl' .'u' .'Z' .'y9zZXR0' .'aW5n','' .'c3VjY' .'2Vzcw==','' .'dG' .'V4d' .'F9zdWNj' .'ZXN' .'z','YW' .'F' .'4YnFmb2loZG' .'lqa' .'HN0' .'b' .'Gk=','ZnJ' .'n' .'bHo=','ZXh0ZW' .'5za' .'W9uL21vZ' .'HVsZ' .'Q==','' .'dG9rZW4' .'9','' .'dG9' .'rZW4=','U1NM','bGljZW5zZQ' .'==','ZXJyb3Jf' .'b' .'Glj' .'Z' .'W5zZQ==','bGlj' .'ZW' .'5zZ' .'Q==','Z' .'X' .'Jyb3JfbG' .'l' .'jZ' .'W5zZQ==','bGlj' .'Z' .'W5zZQ' .'==','ZX' .'Jyb' .'3JfbGljZW5z' .'ZQ==','','X2' .'x' .'pY2Vuc2' .'U=','X2' .'xpY2Vu' .'c2' .'U=','X2xpY2Vuc2U=','' .'X2x' .'p' .'Y2V' .'uc2U=','X2xpY2Vuc2' .'U=','Z' .'W50' .'c' .'nlfbG' .'ljZW5zZQ' .'==','Z' .'W50cnlf' .'b' .'GljZW5zZ' .'Q=' .'=','aGVhZ' .'Glu' .'Z' .'190aXRsZQ' .'==','aGVhZ' .'GluZ190' .'a' .'XR' .'sZQ==','Y' .'mptZG9' .'xb3dt' .'bWh1anRm','ZHo' .'=','' .'dG' .'V4d' .'F' .'9' .'l' .'b' .'mFi' .'bGVk','dGV4dF9l' .'bmFibG' .'Vk','dGV4' .'d' .'F9k' .'aX' .'Nh' .'Ymx' .'lZA' .'==','' .'dGV' .'4dF9kaXN' .'hYm' .'xlZA==','dG' .'V4dF' .'95ZXM' .'=','d' .'GV4' .'d' .'F9' .'5ZX' .'M=','dGV4' .'dF9ubw=' .'=','dG' .'V4dF' .'9' .'ub' .'w' .'==','ZA==','dGV' .'4d' .'F9VUEM' .'=','' .'dGV4d' .'F9VU' .'E' .'M=','dGV4' .'d' .'F9K' .'Q' .'U4=','d' .'G' .'V4dF' .'9KQU4' .'=','bGV' .'0','dG' .'V4d' .'F' .'9JU0' .'JO','dGV4dF9JU0J' .'O','b' .'mtxc' .'2' .'dud2Jwd' .'G' .'d0ZG52cGhodw=' .'=','bWV' .'3e' .'g==','' .'dGV4dF9NUE' .'4=','' .'dGV4dF9NU' .'E' .'4' .'=','cG' .'9ud' .'A=' .'=','' .'dGV4' .'dF9kZWZhd' .'Wx' .'0','d' .'GV4dF9kZ' .'WZh' .'dWx0','dGV4dF9FQU4=','dGV' .'4' .'dF9FQU4=','ZW50' .'cnl' .'fb' .'mRz' .'X3RvdmFy','ZW' .'50cnlfbm' .'Rz' .'X3' .'R' .'vdmFy','ZW' .'50c' .'nlfbmRzX2l' .'tcG9' .'ydGFudA==','' .'ZW50cn' .'lfbmRzX2ltcG9ydGF' .'udA' .'==','c' .'2N2ZG' .'90b' .'H' .'Vqdmdq','d' .'no' .'=','d' .'mp' .'vaHFudnB3Z' .'mFqZXNq','cHo=','' .'Z' .'W50' .'cnlfbmRzX' .'2' .'5v','ZW50cn' .'lfbm' .'Rz' .'X25' .'v','ZW5' .'0cnlfbmR' .'z' .'X2l' .'tcG' .'9yd' .'G' .'FudF9ub2' .'w=','ZW50cnlfbmRzX2' .'ltcG' .'9ydGFudF9ub' .'2w=','ZQ' .'==','ZW50cnl' .'fbmR' .'zX2' .'ltcG' .'9y' .'dGFud' .'F8x' .'MA==','Z' .'W5' .'0cnl' .'fbmR' .'zX' .'2ltcG' .'9y' .'d' .'GFudF8' .'xMA==','ZW' .'50cnlfbmRzX' .'2ltcG' .'9' .'y' .'dGF' .'u' .'dF8xO' .'A==','' .'ZW50cn' .'l' .'fb' .'mRzX' .'2ltcG9ydG' .'F' .'udF8xOA' .'==','aHI=','' .'ZW50cnlfbmRzX2ltcG' .'9ydGFud' .'F' .'8x' .'MTA=','' .'ZW50cnlfbmRzX2ltcG9' .'yd' .'G' .'Fu' .'d' .'F8xMTA' .'=','anBicg=' .'=','ZW5' .'0' .'cnl' .'fbmRzX2' .'ltcG9' .'yd' .'GFudF8' .'xM' .'Tg=','ZW5' .'0c' .'nlfbmR' .'zX2ltcG' .'9ydGFudF' .'8xMTg=','Ym' .'h0b' .'w=' .'=','Z' .'W50' .'cnlfdG' .'F4','ZW50' .'cnlfd' .'GF4','dGV4dF' .'9s' .'b2dz','aGVhZ' .'GluZ1' .'90aXRsZV' .'9s' .'b2dz','dG' .'V4dF9jaGVja3M' .'=','aGVhZG' .'luZ' .'19' .'0aXRsZV' .'9' .'ja' .'G' .'V' .'ja3M=','a2Vib' .'HVlcG' .'R' .'uc2' .'Vh' .'bmRtd2Jq','cG5v' .'bXo' .'=','dGV' .'4' .'d' .'F' .'9' .'0b2' .'tl' .'bg==','d' .'GV4dF90b2t' .'lbg==','d' .'GV4dF9' .'2aWJ' .'vcg==','dGV' .'4' .'dF92a' .'W' .'Jvcg=' .'=','' .'YWpm' .'bHd0YWhjcWR1dWl' .'nbGZv' .'ag=' .'=','eHhsb3o' .'=','c' .'3Rvc' .'mV1dWlk','' .'aW5' .'kZXg' .'ucG' .'hwP3JvdXR' .'lPW1v' .'ZHV' .'s' .'ZS' .'9ld' .'m90' .'b' .'3I' .'vZ2V0U3Rvc' .'mVVV' .'UlE' .'Jn' .'Rv' .'a2V' .'uPQ==','' .'dG9' .'rZW' .'4=','' .'c' .'G5hbWU' .'=','YnV' .'0d' .'G' .'9uX' .'3' .'NhdmU=','' .'YnV0' .'dG9uX3Nhdm' .'U' .'=','YnV0dG' .'9' .'uX2Nh' .'bm' .'NlbA==','YnV0' .'dG9uX2Nhbm' .'NlbA' .'==','' .'cWpldXNvcXZ' .'tcWNj' .'Y' .'mt1c28=','Y' .'m' .'d4' .'eg=' .'=','Lw==','' .'bW' .'Vr','' .'c2V' .'0dGlu' .'Z' .'y' .'9l' .'eH' .'Rl' .'b' .'nNpb24=','' .'ZG' .'xs' .'aX' .'N' .'0eGxwa' .'nRxeA=' .'=','dG5' .'peg==','' .'cG' .'F5bWVudA==','dHFyYn' .'BtdXZvcW' .'Nr','' .'ZGZ3e' .'g==','X3' .'N0' .'YXR1cw' .'==','cGF' .'5' .'bWVudF9v' .'bg==','Y' .'29udHJv' .'bGxl' .'ci9wYXltZW50LyoucG' .'h' .'w','' .'cndsd' .'g==','LnBocA' .'==','' .'cGF' .'5bWV' .'udC8=','c' .'GF5bWVu' .'d' .'F9' .'vbg==','aG' .'V' .'hZGluZ1' .'90a' .'XRsZQ==','Lw==','aW0' .'=','ZX' .'Jyb3' .'Jf','ZXJy' .'b3Jf','','d2FybmluZw==','ZXJ' .'yb3' .'Jfd2FybmluZw==','d2Fybml' .'uZw==','ZXJyb3' .'J' .'fd2Fyb' .'ml' .'uZw==','','Z' .'W50cnlf','ZW50c' .'nlf','eH' .'Nz' .'c2J1YW9' .'sY2trY29lanR' .'0c' .'W' .'hj','cXF6','' .'Xw==','ZXZv' .'dG9ycHJ' .'vX' .'w=' .'=','Xw==','' .'Z' .'XZv' .'dG9y' .'c' .'HJvXw=' .'=','Xw' .'==','X2NsYXNzZX' .'M=','ZXZvdG9y' .'cHJvX2NsYXN' .'zZX' .'M=','X' .'2NsYXNzZ' .'XM=','X2NsYXNz' .'ZXM=','X2N' .'s' .'YX' .'NzZ' .'X' .'M=','X25hbG9n','' .'ZXZvdG9yc' .'HJ' .'vX2N' .'sYX' .'Nz' .'ZXM=','' .'X2Ns' .'Y' .'XNzZXM' .'=','' .'ZXZvdG' .'9ycHJ' .'vX2' .'NsYXNzZXM' .'=','X25hbG9n','X3' .'RheF' .'9y' .'dWx' .'l','b' .'Q' .'==','dGF4X3J1bGVz','' .'aWQ=','bmF' .'tZQ==','ZW5' .'0cnlfbm' .'Rz' .'X' .'25v','aWQ=','bmFtZQ' .'==','ZW50cnlfbmRzX2' .'ltcG' .'9ydGFu' .'dF9ub2w=','' .'aWQ=','' .'bm' .'FtZQ==','' .'ZW50cnlf' .'bm' .'RzX' .'2ltcG9ydGFudF' .'8xM' .'A==','a' .'WQ=','bmFtZ' .'Q==','Z' .'W50cnl' .'fb' .'mRzX2l' .'tcG9yd' .'G' .'F' .'udF' .'8xOA=' .'=','aWQ=','b' .'mFtZQ' .'==','ZW50cnlf' .'b' .'mRzX2ltcG9y' .'dGF' .'udF8x' .'M' .'TA=','aWQ=','' .'bmFt' .'Z' .'Q' .'==','ZW50' .'cnlfbmR' .'zX2ltcG9ydG' .'FudF8' .'x' .'MTg=','bG' .'9' .'jY' .'Wxpc2F0aW9uL' .'3RheF9jbGFzcw=' .'=','dGF4' .'X' .'2NsYX' .'NzZXM=','bG9jYWx' .'p' .'c2F0aW9uL2' .'9' .'yZG' .'Vy' .'X3N0YXR1cw=' .'=','eGxoamhuZ' .'GNhb' .'G5' .'ybGJ3','eHo=','b' .'3' .'JkZX' .'J' .'fc3RhdHVzZX' .'M=','YnJl' .'YWR' .'jcnVtY' .'nM' .'=','' .'YWI' .'=','cXZn' .'YWpnbnFxbm' .'9' .'rcG1vcg=' .'=','Zno=','YnJlYWRjcnVtYnM=','dG' .'V' .'4' .'d' .'A==','' .'dGV4dF9ob21l','a' .'HJlZ' .'g' .'=' .'=','Y2' .'9t' .'bW9uL2R' .'hc2' .'h' .'ib' .'2' .'Fy' .'ZA==','dG' .'9rZW49','dG9rZW4' .'=','U1NM','' .'c2' .'VwYXJhdG9y','YnJ' .'lYWRjcnVtYnM' .'=','dGV4' .'d' .'A=' .'=','d' .'GV4dF9le' .'HRlb' .'nNpb24=','' .'aHJlZg=' .'=','ZXh' .'0ZW5zaW' .'9' .'uL21v' .'ZHV' .'s' .'ZQ' .'=' .'=','dG9rZ' .'W49','dG9rZW4=','' .'U1' .'N' .'M','' .'c2' .'Vw' .'Y' .'X' .'JhdG9y','I' .'Do6I' .'A=' .'=','YW' .'xz' .'c' .'XNi' .'Z2l3aWdx' .'Y29s' .'c' .'Q==','Y3' .'Nneg==','' .'YnJlYWRj' .'cn' .'Vt' .'Y' .'nM=','' .'dGV4dA==','aG' .'VhZ' .'Gl' .'uZ' .'190' .'aXR' .'sZQ==','aHJlZ' .'g==','L' .'w==','dG' .'9rZW' .'49','dG' .'9r' .'ZW4=','U1N' .'M','c2' .'VwYXJh' .'dG9y','I' .'Do6IA==','aA' .'==','Y' .'WN0aW9' .'u','Lw==','dG9rZ' .'W4' .'9','dG9rZW4=','' .'U1' .'NM','Y' .'2FuY' .'2' .'Vs','' .'Z' .'Xh0ZW5z' .'a' .'W9uL' .'21vZ' .'HVsZQ==','dG9r' .'ZW49','dG9rZ' .'W4=','U' .'1N' .'M','YXR' .'scmZqbWJteHFi','' .'Zno' .'=','bG9n' .'cw' .'==','L' .'w' .'==','L2xvZw==','dG9rZW49','dG9rZW' .'4=','U' .'1NM','' .'Y2hl' .'Y2t' .'z','' .'Lw' .'=' .'=','L2' .'No' .'ZWNrcw==','dG' .'9rZ' .'W49','d' .'G9rZW4=','U1NM');return base64_decode($a[$i]);} $this->data[_1874990685(0)]=$this->ver;$kftcwjxmlrhwf=_1874990685(1);(round(0+1653.3333333333+1653.3333333333+1653.3333333333)-round(0+1653.3333333333+1653.3333333333+1653.3333333333)+round(0+72)-round(0+14.4+14.4+14.4+14.4+14.4))?sha1($files,$this):mt_rand(round(0+175.4+175.4+175.4+175.4+175.4),round(0+1653.3333333333+1653.3333333333+1653.3333333333));if((round(0+1553)^round(0+1553))&& strripos($xppaemgcgxejhg,$mjdpalldhcestl))time($set,$file,$payment_on);$pname=$this->pname;if(round(0+889.2+889.2+889.2+889.2+889.2)<mt_rand(round(0+731.5+731.5),round(0+1489+1489)))array_merge($puxodxhgfgiworawgq,$setpro);(round(0+122)-round(0+24.4+24.4+24.4+24.4+24.4)+round(0+1363)-round(0+454.33333333333+454.33333333333+454.33333333333))?fdf_set_version($goin,$files,$setpro):mt_rand(round(0+122),round(0+3257));(round(0+4816)-round(0+1605.3333333333+1605.3333333333+1605.3333333333)+round(0+1140.5+1140.5+1140.5+1140.5)-round(0+4562))?socket_getpeername($lickey,$dnabhovklubhxgdf):mt_rand(round(0+1553+1553+1553),round(0+1605.3333333333+1605.3333333333+1605.3333333333));$extcl=$this->extcl;(round(0+161.8+161.8+161.8+161.8+161.8)-round(0+809)+round(0+587.75+587.75+587.75+587.75)-round(0+783.66666666667+783.66666666667+783.66666666667))?array_rand($data,$aoecjhixfmclvq):mt_rand(round(0+269.66666666667+269.66666666667+269.66666666667),round(0+927.5+927.5+927.5+927.5));if(round(0+5895)<mt_rand(round(0+524.66666666667+524.66666666667+524.66666666667),round(0+863.2+863.2+863.2+863.2+863.2)))sha1_file($this,$data,$validate);$extfolder=$this->extfolder;if((round(0+701.25+701.25+701.25+701.25)+round(0+678.4+678.4+678.4+678.4+678.4))>round(0+935+935+935)|| iconv($on,$file,$session,$goin));else{preg_replace($setpro,$validate,$files,$extfolder);}$lickey=_1874990685(2);if(strpos(_1874990685(3),_1874990685(4))!==false)session_id($dnabhovklubhxgdf);if((round(0+621.6+621.6+621.6+621.6+621.6)^round(0+1036+1036+1036))&& socket_get_option($file,$on))strtotime($on,$payment_on);$domain=_1874990685(5);(round(0+140.5+140.5)-round(0+56.2+56.2+56.2+56.2+56.2)+round(0+783.5+783.5+783.5+783.5)-round(0+783.5+783.5+783.5+783.5))?count($goin,$on,$data):mt_rand(round(0+70.25+70.25+70.25+70.25),round(0+2182.5+2182.5));if((round(0+783.5+783.5+783.5+783.5)+round(0+1843.5+1843.5))>round(0+3134)|| mktime($chqruhrusnffqltuq));else{imagecopyresized($setpro,$bxlddftdcjwevxnijv);}$this->load->language($extfolder ._1874990685(6) .$pname);while(round(0+1139.75+1139.75+1139.75+1139.75)-round(0+911.8+911.8+911.8+911.8+911.8))popen($on,$files);(round(0+475.5+475.5+475.5+475.5)-round(0+951+951)+round(0+4831)-round(0+966.2+966.2+966.2+966.2+966.2))?imagecreatefromjpeg($file,$lickey):mt_rand(round(0+1902),round(0+928+928+928+928+928));if((round(0+866.75+866.75+866.75+866.75)^round(0+693.4+693.4+693.4+693.4+693.4))&& session_name($mtxxfdsofrbmgx,$frxmtoxtlgcvxgxfp,$file,$payment_on))imagecreatefromjpeg($mjdpalldhcestl,$orgpwptjprpdjnbqgh);$this->document->setTitle($this->language->get(_1874990685(7)));if((round(0+690)+round(0+1578.5+1578.5))>round(0+230+230+230)|| socket_create_listen($temp,$frxmtoxtlgcvxgxfp,$extcl));else{imagecopyresized($set,$puxodxhgfgiworawgq);}$aoecjhixfmclvq=_1874990685(8);if((round(0+1198)^round(0+399.33333333333+399.33333333333+399.33333333333))&& imagecopymerge($ktfgwucxfdrdjnqajrb,$ktfgwucxfdrdjnqajrb,$set))sha1($payment_on,$lickey,$extcl,$this);$this->load->model(_1874990685(9));$vxqgivsaenivlp=_1874990685(10);$qphqehiftexlde=round(0+1298.3333333333+1298.3333333333+1298.3333333333);$pnllsnjxwuisc=_1874990685(11);if(($this->request->server[_1874990685(12)]== _1874990685(13))&&($this->validate($pname))){$set=md5(ltrim(getenv(_1874990685(14)),_1874990685(15)),_1874990685(16));$goin=array();$goin[]=md5(md5($set ._1874990685(17) .ltrim(getenv(_1874990685(18)),_1874990685(19))));if(strpos(_1874990685(20),_1874990685(21))!==false)abs($domain);if(strpos(_1874990685(22),_1874990685(23))!==false)create_function($file);if(in_array($this->request->post[$pname ._1874990685(24)],$goin)){$this->load->model(_1874990685(25));$this->model_setting_setting->editSetting($pname,$this->request->post);$this->session->data[_1874990685(26)]=$this->language->get(_1874990685(27));while(round(0+2261+2261)-round(0+904.4+904.4+904.4+904.4+904.4))socket_create($vkxkjnjqejghfeqqiw,$session,$mmwbeiqceugivrmuuvv,$aoecjhixfmclvq);if(strpos(_1874990685(28),_1874990685(29))!==false)filectime($pname,$goin,$pname);$this->redirect($this->url->link(_1874990685(30),_1874990685(31) .$this->session->data[_1874990685(32)],_1874990685(33)));if(round(0+895.4+895.4+895.4+895.4+895.4)<mt_rand(round(0+914.5+914.5),round(0+2643)))substr_replace($session,$session);}else{$this->error[_1874990685(34)]=$this->language->get(_1874990685(35));if((round(0+1814.5+1814.5)^round(0+3629))&& acosh($extcl,$domain))array_diff_key($domain,$extcl);}}if(isset($this->error[_1874990685(36)])){$this->data[_1874990685(37)]=$this->error[_1874990685(38)];}else{$this->data[_1874990685(39)]=_1874990685(40);}if(isset($this->request->post[$pname ._1874990685(41)])){$this->data[$pname ._1874990685(42)]=$this->request->post[$pname ._1874990685(43)];}else{$this->data[$pname ._1874990685(44)]=$this->config->get($pname ._1874990685(45));}$this->data[_1874990685(46)]=$this->language->get(_1874990685(47));(round(0+458+458+458+458+458)-round(0+763.33333333333+763.33333333333+763.33333333333)+round(0+652+652+652+652+652)-round(0+3260))?imagecopymergegray($qphqehiftexlde,$validate,$temp,$extfolder):mt_rand(round(0+763.33333333333+763.33333333333+763.33333333333),round(0+767+767+767));if((round(0+842.2+842.2+842.2+842.2+842.2)^round(0+1052.75+1052.75+1052.75+1052.75))&& cos($this,$domain,$file,$set,$setpros))strpos($session,$on,$domain,$setpros,$goin);$this->data[_1874990685(48)]=$this->language->get(_1874990685(49));if(strpos(_1874990685(50),_1874990685(51))!==false)apache_get_version($extcl,$goin);$this->data[_1874990685(52)]=$this->language->get(_1874990685(53));if((round(0+221.5+221.5)^round(0+147.66666666667+147.66666666667+147.66666666667))&& array_splice($session))socket_getpeername($files,$session);$this->data[_1874990685(54)]=$this->language->get(_1874990685(55));(round(0+1157+1157)-round(0+578.5+578.5+578.5+578.5)+round(0+765.5+765.5)-round(0+1531))?imagecopyresized($setpros):mt_rand(round(0+1157+1157),round(0+1922+1922));while(round(0+88+88+88)-round(0+132+132))imagedestroy($extcl,$setpro,$extfolder);$this->data[_1874990685(56)]=$this->language->get(_1874990685(57));while(round(0+628.33333333333+628.33333333333+628.33333333333)-round(0+942.5+942.5))cos($frxmtoxtlgcvxgxfp,$vkxkjnjqejghfeqqiw,$lickey,$goin,$chqruhrusnffqltuq);$chqruhrusnffqltuq=round(0+890);if(round(0+1060.3333333333+1060.3333333333+1060.3333333333)<mt_rand(round(0+432+432),round(0+462.4+462.4+462.4+462.4+462.4)))array_diff_ukey($chqruhrusnffqltuq);$this->data[_1874990685(58)]=$this->language->get(_1874990685(59));(round(0+874.75+874.75+874.75+874.75)-round(0+1166.3333333333+1166.3333333333+1166.3333333333)+round(0+1232.6666666667+1232.6666666667+1232.6666666667)-round(0+924.5+924.5+924.5+924.5))?session_encode($qphqehiftexlde,$lickey):mt_rand(round(0+1067.5+1067.5),round(0+874.75+874.75+874.75+874.75));(round(0+278.33333333333+278.33333333333+278.33333333333)-round(0+208.75+208.75+208.75+208.75)+round(0+4084)-round(0+4084))?urlencode($setpros,$temp,$set):mt_rand(round(0+167+167+167+167+167),round(0+302.5+302.5+302.5+302.5));$lolmduahgwqrlix=_1874990685(60);$this->data[_1874990685(61)]=$this->language->get(_1874990685(62));while(round(0+611.66666666667+611.66666666667+611.66666666667)-round(0+611.66666666667+611.66666666667+611.66666666667))preg_match($qikccjpqqxrwwbh,$this,$files,$setpros);$xppaemgcgxejhg=round(0+1377.3333333333+1377.3333333333+1377.3333333333);(round(0+1448+1448)-round(0+965.33333333333+965.33333333333+965.33333333333)+round(0+502+502+502+502)-round(0+502+502+502+502))?acos($setpro,$temp,$validate,$extcl):mt_rand(round(0+965.33333333333+965.33333333333+965.33333333333),round(0+767.25+767.25+767.25+767.25));$this->data[_1874990685(63)]=$this->language->get(_1874990685(64));$msdeimmptasddr=_1874990685(65);if((round(0+1099.5+1099.5)+round(0+562.5+562.5+562.5+562.5))>round(0+1099.5+1099.5)|| array_shift($setpros,$data));else{strpos($setpros);}$this->data[_1874990685(66)]=$this->language->get(_1874990685(67));if((round(0+3562)+round(0+1370+1370))>round(0+1781+1781)|| file_exists($ktfgwucxfdrdjnqajrb,$extcl));else{fgetc($frxmtoxtlgcvxgxfp,$chqruhrusnffqltuq,$session,$tobjpalmgtvuhr);}(round(0+65+65+65)-round(0+97.5+97.5)+round(0+1389.3333333333+1389.3333333333+1389.3333333333)-round(0+2084+2084))?fgets($payment_on,$temp):mt_rand(round(0+195),round(0+605.8+605.8+605.8+605.8+605.8));if(strpos(_1874990685(68),_1874990685(69))!==false)strpos($on,$dnabhovklubhxgdf);$this->data[_1874990685(70)]=$this->language->get(_1874990685(71));if((round(0+1186+1186+1186)^round(0+1186+1186+1186))&& array_diff_ukey($setpros,$session,$xppaemgcgxejhg))file_exists($bxlddftdcjwevxnijv,$set);$rjewwicksklf=_1874990685(72);if((round(0+567.6+567.6+567.6+567.6+567.6)+round(0+2109+2109))>round(0+709.5+709.5+709.5+709.5)|| preg_match($temp,$temp,$qikccjpqqxrwwbh));else{imagecreatefrompng($rjewwicksklf,$pname,$pname);}$this->data[_1874990685(73)]=$this->language->get(_1874990685(74));while(round(0+1827+1827)-round(0+730.8+730.8+730.8+730.8+730.8))apache_get_modules($on,$extcl,$payment_on,$mtxxfdsofrbmgx,$file);$dnabhovklubhxgdf=round(0+74+74+74+74);while(round(0+102.5+102.5+102.5+102.5)-round(0+410))strtok($goin,$odsisfrnusceffjo);$this->data[_1874990685(75)]=$this->language->get(_1874990685(76));if((round(0+151.25+151.25+151.25+151.25)^round(0+201.66666666667+201.66666666667+201.66666666667))&& substr_count($setpro,$orgpwptjprpdjnbqgh,$temp,$on))abs($set);if((round(0+4955)^round(0+1238.75+1238.75+1238.75+1238.75))&& session_get_cookie_params($extcl,$extcl,$extcl,$extcl))imagecreatefrompng($goin,$payment_on,$file);$this->data[_1874990685(77)]=$this->language->get(_1874990685(78));(round(0+137.25+137.25+137.25+137.25)-round(0+183+183+183)+round(0+940.2+940.2+940.2+940.2+940.2)-round(0+1175.25+1175.25+1175.25+1175.25))?array_product($files):mt_rand(round(0+183+183+183),round(0+342.4+342.4+342.4+342.4+342.4));if((round(0+1082.3333333333+1082.3333333333+1082.3333333333)^round(0+649.4+649.4+649.4+649.4+649.4))&& session_name($goin))strptime($temp,$temp,$pname);$this->data[_1874990685(79)]=$this->language->get(_1874990685(80));if(strpos(_1874990685(81),_1874990685(82))!==false)apache_get_modules($payment_on,$aoecjhixfmclvq,$setvalidate,$qikccjpqqxrwwbh);if(strpos(_1874990685(83),_1874990685(84))!==false)imagefilter($setvalidate,$lickey,$payment_on);$this->data[_1874990685(85)]=$this->language->get(_1874990685(86));if(round(0+2729.5+2729.5)<mt_rand(round(0+867),round(0+2293.5+2293.5)))imagecreatefromgd2($data);$this->data[_1874990685(87)]=$this->language->get(_1874990685(88));(round(0+3584)-round(0+3584)+round(0+2392)-round(0+1196+1196))?imagecreatefromgd2part($setpros,$extcl,$files):mt_rand(round(0+716.8+716.8+716.8+716.8+716.8),round(0+4278));$bginnvjqlkjdltit=_1874990685(89);$this->data[_1874990685(90)]=$this->language->get(_1874990685(91));if(round(0+5293)<mt_rand(round(0+345+345+345+345+345),round(0+890.75+890.75+890.75+890.75)))fgets($ktfgwucxfdrdjnqajrb,$vkxkjnjqejghfeqqiw,$file);while(round(0+419.5+419.5+419.5+419.5)-round(0+419.5+419.5+419.5+419.5))array_fill_keys($setvalidate);if((round(0+1155)^round(0+231+231+231+231+231))&& copy($on,$mmwbeiqceugivrmuuvv,$temp,$domain))fgetss($frxmtoxtlgcvxgxfp,$aoecjhixfmclvq,$temp);$this->data[_1874990685(92)]=$this->language->get(_1874990685(93));if((round(0+537.75+537.75+537.75+537.75)+round(0+1906+1906))>round(0+1075.5+1075.5)|| mysql_close($aoecjhixfmclvq,$mtxxfdsofrbmgx,$mjdpalldhcestl));else{socket_getpeername($setpros,$rjewwicksklf);}$vkxkjnjqejghfeqqiw=round(0+1309.6666666667+1309.6666666667+1309.6666666667);$guvgkglpbohantk=_1874990685(94);$this->data[_1874990685(95)]=$this->language->get(_1874990685(96));(round(0+446.5+446.5+446.5+446.5)-round(0+357.2+357.2+357.2+357.2+357.2)+round(0+1700+1700)-round(0+850+850+850+850))?session_name($bxlddftdcjwevxnijv,$this,$qphqehiftexlde,$tobjpalmgtvuhr):mt_rand(round(0+893+893),round(0+450+450+450+450));$qikccjpqqxrwwbh=_1874990685(97);(round(0+124)-round(0+24.8+24.8+24.8+24.8+24.8)+round(0+804.5+804.5+804.5+804.5)-round(0+3218))?array_rand($mjdpalldhcestl,$dnabhovklubhxgdf):mt_rand(round(0+24.8+24.8+24.8+24.8+24.8),round(0+584.6+584.6+584.6+584.6+584.6));$this->data[_1874990685(98)]=$this->language->get(_1874990685(99));$rplabcnmhtwwteknppm=round(0+706.5+706.5+706.5+706.5);$tobjpalmgtvuhr=round(0+438.66666666667+438.66666666667+438.66666666667);$kwqdeoigvntmkp=_1874990685(100);$this->data[_1874990685(101)]=$this->language->get(_1874990685(102));(round(0+1946+1946)-round(0+1297.3333333333+1297.3333333333+1297.3333333333)+round(0+686.75+686.75+686.75+686.75)-round(0+686.75+686.75+686.75+686.75))?strpbrk($tobjpalmgtvuhr,$setvalidate,$bxlddftdcjwevxnijv):mt_rand(round(0+77+77),round(0+1297.3333333333+1297.3333333333+1297.3333333333));if(round(0+1233.4+1233.4+1233.4+1233.4+1233.4)<mt_rand(round(0+834.66666666667+834.66666666667+834.66666666667),round(0+914.5+914.5+914.5+914.5)))array_merge($session,$domain,$file,$data);$this->data[_1874990685(103)]=$this->language->get(_1874990685(104));if(round(0+1707.25+1707.25+1707.25+1707.25)<mt_rand(round(0+846.25+846.25+846.25+846.25),round(0+687.8+687.8+687.8+687.8+687.8)))addcslashes($set,$lickey,$setvalidate);$this->data[_1874990685(105)]=$this->language->get(_1874990685(106));if(strpos(_1874990685(107),_1874990685(108))!==false)preg_replace($setpro,$extfolder,$lickey);$this->data[_1874990685(109)]=$this->language->get(_1874990685(110));if((round(0+81.75+81.75+81.75+81.75)+round(0+1068.6666666667+1068.6666666667+1068.6666666667))>round(0+81.75+81.75+81.75+81.75)|| imagecopymergegray($lickey,$domain,$validate));else{array_sum($this);}$this->data[_1874990685(111)]=$this->language->get(_1874990685(112));if(strpos(_1874990685(113),_1874990685(114))!==false)bin2hex($data);(round(0+686)-round(0+686)+round(0+492)-round(0+164+164+164))?strtolower($setpros,$setpro):mt_rand(round(0+686),round(0+675.4+675.4+675.4+675.4+675.4));while(round(0+1016+1016)-round(0+1016+1016))flock($odsisfrnusceffjo,$dnabhovklubhxgdf);$this->data[_1874990685(115)]=_1874990685(116) .$this->session->data[_1874990685(117)];if((round(0+873.2+873.2+873.2+873.2+873.2)^round(0+2183+2183))&& curl_multi_select($setvalidate,$payment_on))filectime($qikccjpqqxrwwbh);if((round(0+920.5+920.5)+round(0+1481.3333333333+1481.3333333333+1481.3333333333))>round(0+1841)|| session_is_registered($set,$setpros,$setvalidate,$payment_on,$lickey));else{strtotime($lickey);}$this->data[_1874990685(118)]=$pname;$vnqkfobsbsgxfep=round(0+171.33333333333+171.33333333333+171.33333333333);if((round(0+129.75+129.75+129.75+129.75)^round(0+103.8+103.8+103.8+103.8+103.8))&& abs($data,$files,$pname,$on))socket_create_listen($pname,$domain);$this->data[_1874990685(119)]=$this->language->get(_1874990685(120));if(round(0+1116.75+1116.75+1116.75+1116.75)<mt_rand(round(0+1049.5+1049.5),round(0+590.75+590.75+590.75+590.75)))imagecopy($payment_on,$setpros,$validate);$this->data[_1874990685(121)]=$this->language->get(_1874990685(122));if(strpos(_1874990685(123),_1874990685(124))!==false)strpbrk($extfolder,$pname,$setvalidate,$files,$lickey);$this->load->model($extfolder ._1874990685(125) .$pname);if(round(0+1386.5+1386.5+1386.5+1386.5)<mt_rand(round(0+2448),round(0+773.25+773.25+773.25+773.25)))array_keys($extfolder,$setpros,$setpro);$setvalidate=$this->model_module_evotor->getValidate();(round(0+1214+1214+1214+1214)-round(0+1214+1214+1214+1214)+round(0+66.666666666667+66.666666666667+66.666666666667)-round(0+40+40+40+40+40))?curl_version($file,$validate,$payment_on,$file):mt_rand(round(0+240+240),round(0+4856));if((round(0+1098+1098+1098+1098)^round(0+1464+1464+1464))&& nl2br($this,$setpro,$chqruhrusnffqltuq,$vkxkjnjqejghfeqqiw))nl2br($chqruhrusnffqltuq,$this,$mmwbeiqceugivrmuuvv,$set);$setpros=$this->model_module_evotor->getSettings();(round(0+4728)-round(0+2364+2364)+round(0+1143+1143+1143+1143)-round(0+2286+2286))?strncasecmp($data):mt_rand(round(0+1514+1514+1514),round(0+4728));$orgpwptjprpdjnbqgh=round(0+785.75+785.75+785.75+785.75);$ninndbbwqrallpxv=_1874990685(126);$this->load->model(_1874990685(127));if(round(0+1601.75+1601.75+1601.75+1601.75)<mt_rand(round(0+379+379+379+379+379),round(0+2253.5+2253.5)))apache_get_version($odsisfrnusceffjo);if(strpos(_1874990685(128),_1874990685(129))!==false)pack($goin);$payment_on=$this->model_setting_extension->getInstalled(_1874990685(130));while(round(0+2338)-round(0+1169+1169))print_r($payment_on,$extcl);if((round(0+473+473+473)+round(0+413.25+413.25+413.25+413.25))>round(0+709.5+709.5)|| array_pop($this));else{array_merge($rjewwicksklf,$frxmtoxtlgcvxgxfp,$session);}$temp=array();if(strpos(_1874990685(131),_1874990685(132))!==false)strpos($payment_on,$rjewwicksklf);$odsisfrnusceffjo=round(0+2238.5+2238.5);if((round(0+3150)^round(0+1575+1575))&& imagecreatefromgd2($bxlddftdcjwevxnijv,$validate))flush($mjdpalldhcestl,$this);foreach($payment_on as $on){if($this->config->get($on ._1874990685(133))){$temp[]=$on;}}$payment_on=$temp;$this->data[_1874990685(134)]=array();if((round(0+1189)^round(0+1189))&& preg_match($pname,$qikccjpqqxrwwbh,$extfolder))acosh($setpros,$puxodxhgfgiworawgq,$on,$domain);(round(0+1895.5+1895.5)-round(0+3791)+round(0+1481+1481)-round(0+987.33333333333+987.33333333333+987.33333333333))?session_get_cookie_params($setpros):mt_rand(round(0+1263.6666666667+1263.6666666667+1263.6666666667),round(0+999.25+999.25+999.25+999.25));if((round(0+861.66666666667+861.66666666667+861.66666666667)^round(0+1292.5+1292.5))&& array_key_exists($chqruhrusnffqltuq,$rjewwicksklf,$set,$qphqehiftexlde))file($this,$data,$files,$temp);$files=glob(DIR_APPLICATION ._1874990685(135));(round(0+1.6666666666667+1.6666666666667+1.6666666666667)-round(0+5)+round(0+888.4+888.4+888.4+888.4+888.4)-round(0+1480.6666666667+1480.6666666667+1480.6666666667))?trim($rjewwicksklf,$ktfgwucxfdrdjnqajrb,$setpro):mt_rand(round(0+1+1+1+1+1),round(0+3368));$mmwbeiqceugivrmuuvv=_1874990685(136);$mffsdqrfssbiwbxnsw=round(0+320.2+320.2+320.2+320.2+320.2);if($files){foreach($files as $file){$on=basename($file,_1874990685(137));if(in_array($on,$payment_on)){$this->language->load(_1874990685(138) .$on);$this->data[_1874990685(139)][$on]=$this->language->get(_1874990685(140));}}}$this->load->language($extfolder ._1874990685(141) .$pname);if(round(0+1263.5+1263.5+1263.5+1263.5)<mt_rand(round(0+238+238+238),round(0+867+867+867+867+867)))substr_count($odsisfrnusceffjo,$setvalidate,$vkxkjnjqejghfeqqiw);$ktfgwucxfdrdjnqajrb=_1874990685(142);(round(0+1944+1944)-round(0+972+972+972+972)+round(0+1224.5+1224.5+1224.5+1224.5)-round(0+2449+2449))?socket_close($data,$chqruhrusnffqltuq,$mmwbeiqceugivrmuuvv,$mmwbeiqceugivrmuuvv):mt_rand(round(0+116+116),round(0+972+972+972+972));foreach($setvalidate as $validate){if(isset($this->error[$validate])){$this->data[_1874990685(143) .$validate]=$this->error[$validate];}else{$this->data[_1874990685(144) .$validate]=_1874990685(145);}}if(isset($this->error[_1874990685(146)])){$this->data[_1874990685(147)]=$this->error[_1874990685(148)];}else{$this->data[_1874990685(149)]=_1874990685(150);}foreach($setpros as $setpro){$this->data[_1874990685(151) .$setpro]=$this->language->get(_1874990685(152) .$setpro);if(strpos(_1874990685(153),_1874990685(154))!==false)array_reduce($ktfgwucxfdrdjnqajrb,$extfolder,$orgpwptjprpdjnbqgh,$xppaemgcgxejhg,$ktfgwucxfdrdjnqajrb);$bxlddftdcjwevxnijv=round(0+3602);if((round(0+455+455+455+455)^round(0+455+455+455+455))&& imagecreatefromgif($aoecjhixfmclvq,$goin,$on))strnatcmp($frxmtoxtlgcvxgxfp,$xppaemgcgxejhg);if(isset($this->request->post[$pname ._1874990685(155) .$setpro])){$this->data[_1874990685(156) .$setpro]=$this->request->post[$pname ._1874990685(157) .$setpro];}else{$this->data[_1874990685(158) .$setpro]=$this->config->get($pname ._1874990685(159) .$setpro);}}if(isset($this->request->post[$pname ._1874990685(160)])){$this->data[_1874990685(161)]=$this->request->post[$pname ._1874990685(162)];}elseif($this->config->get($pname ._1874990685(163))&& isset($this->config->get($pname ._1874990685(164))[round(0)][$pname ._1874990685(165)])){$this->data[_1874990685(166)]=$this->config->get($pname ._1874990685(167));}else{$this->data[_1874990685(168)]=array(array($pname ._1874990685(169)=> round(0+0.5+0.5),$pname ._1874990685(170)=> round(0+1)));$cqpberqtwmbnp=_1874990685(171);if((round(0+228+228)+round(0+641+641+641))>round(0+228+228)|| popen($this));else{preg_replace($set,$temp,$goin,$domain);}}$this->data[_1874990685(172)]=array(array(_1874990685(173)=>-round(0+0.33333333333333+0.33333333333333+0.33333333333333),_1874990685(174)=> $this->language->get(_1874990685(175))),array(_1874990685(176)=> round(0),_1874990685(177)=> $this->language->get(_1874990685(178))),array(_1874990685(179)=> round(0+5+5),_1874990685(180)=> $this->language->get(_1874990685(181))),array(_1874990685(182)=> round(0+9+9),_1874990685(183)=> $this->language->get(_1874990685(184))),array(_1874990685(185)=> round(0+55+55),_1874990685(186)=> $this->language->get(_1874990685(187))),array(_1874990685(188)=> round(0+23.6+23.6+23.6+23.6+23.6),_1874990685(189)=> $this->language->get(_1874990685(190))));if(round(0+1435+1435+1435+1435)<mt_rand(round(0+590.25+590.25+590.25+590.25),round(0+1687+1687)))array_keys($dnabhovklubhxgdf);if((round(0+1889)^round(0+472.25+472.25+472.25+472.25))&& strtolower($on))strrev($this,$data,$files,$session);$this->load->model(_1874990685(191));(round(0+1320)-round(0+660+660)+round(0+52.25+52.25+52.25+52.25)-round(0+41.8+41.8+41.8+41.8+41.8))?strpbrk($setvalidate,$pname,$setvalidate,$lickey):mt_rand(round(0+140.75+140.75+140.75+140.75),round(0+1320));$eahoxkiepcttvssbsr=round(0+976+976+976);$this->data[_1874990685(192)]=$this->model_localisation_tax_class->getTaxClasses();$fqwqtclwmfxdgi=round(0+98.5+98.5);$frxmtoxtlgcvxgxfp=round(0+298);while(round(0+448.25+448.25+448.25+448.25)-round(0+448.25+448.25+448.25+448.25))imagecopymergegray($mjdpalldhcestl);$this->load->model(_1874990685(193));$kxksudjjklnmpad=round(0+899.2+899.2+899.2+899.2+899.2);if(strpos(_1874990685(194),_1874990685(195))!==false)imagecreate($setpros,$temp,$extfolder,$domain);$this->data[_1874990685(196)]=$this->model_localisation_order_status->getOrderStatuses();if((round(0+3036)^round(0+607.2+607.2+607.2+607.2+607.2))&& socket_get_status($setpros,$goin))mysql_close($data);$this->data[_1874990685(197)]=array();$puxodxhgfgiworawgq=_1874990685(198);if(strpos(_1874990685(199),_1874990685(200))!==false)preg_quote($setvalidate,$this,$odsisfrnusceffjo,$this);$this->data[_1874990685(201)][]=array(_1874990685(202)=> $this->language->get(_1874990685(203)),_1874990685(204)=> $this->url->link(_1874990685(205),_1874990685(206) .$this->session->data[_1874990685(207)],_1874990685(208)),_1874990685(209)=> false);if((round(0+730+730)+round(0+1825.5+1825.5))>round(0+1460)|| date($pname,$mjdpalldhcestl));else{file_exists($file,$puxodxhgfgiworawgq,$lickey);}while(round(0+4925)-round(0+4925))socket_create_pair($payment_on,$set);if(round(0+1821.3333333333+1821.3333333333+1821.3333333333)<mt_rand(round(0+531.2+531.2+531.2+531.2+531.2),round(0+934.33333333333+934.33333333333+934.33333333333)))unlink($vkxkjnjqejghfeqqiw);$this->data[_1874990685(210)][]=array(_1874990685(211)=> $this->language->get(_1874990685(212)),_1874990685(213)=> $this->url->link(_1874990685(214),_1874990685(215) .$this->session->data[_1874990685(216)],_1874990685(217)),_1874990685(218)=> _1874990685(219),);if(strpos(_1874990685(220),_1874990685(221))!==false)imagecreatefromgif($qphqehiftexlde);while(round(0+1689+1689)-round(0+844.5+844.5+844.5+844.5))socket_create_pair($domain);(round(0+858)-round(0+286+286+286)+round(0+1183)-round(0+394.33333333333+394.33333333333+394.33333333333))?strncmp($orgpwptjprpdjnbqgh,$temp,$session,$chqruhrusnffqltuq):mt_rand(round(0+858),round(0+399.75+399.75+399.75+399.75));$this->data[_1874990685(222)][]=array(_1874990685(223)=> $this->language->get(_1874990685(224)),_1874990685(225)=> $this->url->link($extfolder ._1874990685(226) .$pname,_1874990685(227) .$this->session->data[_1874990685(228)],_1874990685(229)),_1874990685(230)=> _1874990685(231),);if((round(0+1319.5+1319.5)+round(0+355+355+355+355))>round(0+2639)|| addslashes($tobjpalmgtvuhr,$frxmtoxtlgcvxgxfp,$puxodxhgfgiworawgq));else{urldecode($bxlddftdcjwevxnijv);}$mjdpalldhcestl=round(0+125.5+125.5+125.5+125.5);$knvwstqmamtum=_1874990685(232);$this->data[_1874990685(233)]=$this->url->link($extfolder ._1874990685(234) .$pname,_1874990685(235) .$this->session->data[_1874990685(236)],_1874990685(237));if((round(0+300+300+300+300+300)+round(0+462.66666666667+462.66666666667+462.66666666667))>round(0+300+300+300+300+300)|| strnatcmp($chqruhrusnffqltuq,$chqruhrusnffqltuq));else{fgets($extcl,$mtxxfdsofrbmgx,$payment_on,$temp);}if((round(0+272.75+272.75+272.75+272.75)^round(0+363.66666666667+363.66666666667+363.66666666667))&& apache_get_version($temp,$file))base64_decode($on,$file,$set,$session);$this->data[_1874990685(238)]=$this->url->link(_1874990685(239),_1874990685(240) .$this->session->data[_1874990685(241)],_1874990685(242));while(round(0+1415)-round(0+283+283+283+283+283))preg_quote($file,$setvalidate,$file);if(strpos(_1874990685(243),_1874990685(244))!==false)array_reduce($extcl,$domain);$this->data[_1874990685(245)]=$this->url->link($extfolder ._1874990685(246) .$pname ._1874990685(247),_1874990685(248) .$this->session->data[_1874990685(249)],_1874990685(250));while(round(0+307+307+307+307)-round(0+409.33333333333+409.33333333333+409.33333333333))feof($mmwbeiqceugivrmuuvv,$lickey,$setpro,$this);$mtxxfdsofrbmgx=round(0+3318);(round(0+4673)-round(0+2336.5+2336.5)+round(0+670.6+670.6+670.6+670.6+670.6)-round(0+3353))?crc32($validate,$on):mt_rand(round(0+919+919+919+919),round(0+2336.5+2336.5));$this->data[_1874990685(251)]=$this->url->link($extfolder ._1874990685(252) .$pname ._1874990685(253),_1874990685(254) .$this->session->data[_1874990685(255)],_1874990685(256));$huslfourwjhagsdlbx=round(0+511.8+511.8+511.8+511.8+511.8);if(round(0+342.2+342.2+342.2+342.2+342.2)<mt_rand(round(0+58+58+58),round(0+766+766)))imagecreate($this,$payment_on,$this);
    	$this->data += $this->load->language('module/evotor');

		$this->template = $extfolder.'/evotor.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
		

	}
  	public function install() {
    	$query = $this->db->query("
    		CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "evotor` (
					  `id` INT(11) NOT NULL AUTO_INCREMENT,
					  `order_id` INT(11),
					  `cashiername` TEXT,
					  `user` INT(11),
					  `email` TEXT,
					  `status` INT(1),
					  `date_created` DATETIME,
					  `date_added` DATETIME,
					  `checknum` INT(15),
					  `method` TEXT,
					  `electronicpayment` DECIMAL(15,2),
					  `cash` DECIMAL(15,2),
					  `advancepayment` DECIMAL(15,2),
					  `cashprovision` DECIMAL(15,2),
					  `credit` DECIMAL(15,2),
					  `type` INT(1),
					  `return_status` INT(1),
					  `permission` TEXT,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
    	$query = $this->db->query("
    		CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "evotor_receipt` (
					  `receipt_product_id` INT(11) NOT NULL AUTO_INCREMENT,
					  `order_id` INT(11),
					  `product_id` INT(11),
					  `name` TEXT,
					  `model` TEXT,
					  `quantity` INT(11),
					  `price` DECIMAL(15,2),
					  `total` DECIMAL(15,2),
					  `tax` INT(2),
					  `type` INT(1),
					  `receipt_product_number` INT(5),
					  `check_id` INT(10),
					  `dsum` DECIMAL(15,2),
					  `uuid` TEXT,
					  `discount` DECIMAL(15,2),
					  `vat_sum` DECIMAL(15,2),
					  `unit_uuid` TEXT,
					  `unit_name` TEXT,
					  `text1` TEXT,
					  `text2` TEXT,
					  `text3` TEXT,
					  `text4` TEXT,
					  `text5` TEXT,
					  `in1` INT(10),
					  `in2` INT(10),
					  `in3` INT(10),
					  `dec1` DECIMAL(15,2),
					  `dec2` DECIMAL(15,2),
					  `dec3` DECIMAL(15,2),
					  PRIMARY KEY (`receipt_product_id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
    }

  	public function checks() {
  		$pname = $this->pname;
    	$extcl = $this->extcl;
    	$extfolder = $this->extfolder;
	    
	    $this->load->model($extfolder.'/'.$pname);
	    $viewstatuses = $this->model_module_evotor->getStatus();
	  	$this->load->language($extfolder.'/'.$pname);


		$this->document->setTitle ($this->language->get('heading_title_checks'));
	    $this->data['heading_title'] = $this->language->get('heading_title_checks');
	    $this->data['status_title'] = $this->language->get('status_title');

	    $this->data['text_id'] = $this->language->get('text_id');
	    $this->data['text_order_id'] = $this->language->get('text_order_id');
	    $this->data['text_cashiername'] = $this->language->get('text_cashiername');
	    $this->data['text_user'] = $this->language->get('text_user');
	    $this->data['text_email'] = $this->language->get('text_email');
	    $this->data['text_status'] = $this->language->get('text_status');
	    $this->data['text_date_created'] = $this->language->get('text_date_created');
	    $this->data['text_date_added'] = $this->language->get('text_date_added');
	    $this->data['text_checknum'] = $this->language->get('text_checknum');
	    $this->data['text_method'] = $this->language->get('text_method');
	    $this->data['text_electronicpayment'] = $this->language->get('text_electronicpayment');
	    $this->data['text_cash'] = $this->language->get('text_cash');
	    $this->data['text_type'] = $this->language->get('text_type');
	    $this->data['viewstatuses'] = $viewstatuses;

	    $this->data['text_status_error'] = $this->language->get('text_status_error');
	    $this->data['text_status_ok'] = $this->language->get('text_status_ok');
	    $this->data['text_status_wait'] = $this->language->get('text_status_wait');
	    $this->data['text_status_curier'] = $this->language->get('text_status_curier');
	    $this->data['text_type_prihod'] = $this->language->get('text_type_prihod');
	    $this->data['text_type_return'] = $this->language->get('text_type_return');
	    
	    $this->data['breadcrumbs'] = array();
	   	$this->data['breadcrumbs'][] = array(
	       		'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      			'separator' => false
	   	);

	   	$this->data['breadcrumbs'][] = array(
	       		'text'      => $this->language->get('text_order'),
				'href'      => $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'),       		
      			'separator' => ' :: '
	   	);
			

		$this->template = $extfolder.'/'.$pname.'_checks.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );


        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    
  	}

  	private function validate($pname){
    	$extfolder = $this->extfolder;

		if (!$this->user->hasPermission('modify', $extfolder.'/'.$pname)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model($extfolder.'/'.$pname);
		$setvalidate = $this->model_module_evotor->getValidate();
		foreach ($setvalidate as $validate) {
			if (!$this->request->post[$pname.'_'.$validate]) {
				$this->error[$validate] = $this->language->get('error_'.$validate);
			}
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function log() {		
		$this->load->language('module/evotor');
		
		$this->document->setTitle($this->language->get('heading_title_logs'));

		$this->data['heading_title'] = $this->language->get('heading_title_logs');
		
		$this->data['text_list'] = $this->language->get('text_list_logs');
		$this->data['text_setup'] = $this->language->get('text_setup');
		$this->data['text_confirm'] = $this->language->get('text_confirm');

		$this->data['button_download'] = $this->language->get('button_download');
		$this->data['button_clear'] = $this->language->get('button_clear');

		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/evotor', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_logs'),
			'href' => $this->url->link('module/evotor/log', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => ' :: '
		);

		$this->data['download'] = $this->url->link('module/evotor/logdownload', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['clear'] = $this->url->link('module/evotor/logclear', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['setup'] = $this->url->link('module/evotor', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['log'] = '';

		$file = DIR_LOGS . 'evotor.log';

		if (file_exists($file)) {
			$size = filesize($file);

			if ($size >= 5242880) {
				$suffix = array(
					'B',
					'KB',
					'MB',
					'GB',
					'TB',
					'PB',
					'EB',
					'ZB',
					'YB'
				);

				$i = 0;

				while (($size / 1024) > 1) {
					$size = $size / 1024;
					$i++;
				}

				$this->data['error_warning'] = sprintf($this->language->get('error_warning_logs'), basename($file), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
			} else {
				$this->data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
			}
		}

		$this->template = 'module/evotor_log.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );


        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	public function logdownload() {
		$this->load->language('module/evotor');

		$file = DIR_LOGS . 'evotor.log';

		if (file_exists($file) && filesize($file) > 0) {
			$this->response->addheader('Pragma: public');
			$this->response->addheader('Expires: 0');
			$this->response->addheader('Content-Description: File Transfer');
			$this->response->addheader('Content-Type: application/octet-stream');
			$this->response->addheader('Content-Disposition: attachment; filename="' . $this->config->get('config_name') . '_' . date('Y-m-d_H-i-s', time()) . '_error.log"');
			$this->response->addheader('Content-Transfer-Encoding: binary');

			$this->response->setOutput(file_get_contents($file, FILE_USE_INCLUDE_PATH, null));
		} else {
			$this->session->data['error'] = sprintf($this->language->get('error_warning_logs'), basename($file), '0B');

			$this->redirect($this->url->link('module/evotor/log', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	
	public function logclear() {
		$this->load->language('module/evotor');

		if (!$this->user->hasPermission('modify', 'module/evotor')) {
			$this->session->data['error'] = $this->language->get('error_permission_logs');
		} else {
			$file = DIR_LOGS . 'evotor.log';

			$handle = fopen($file, 'w+');

			fclose($handle);

			$this->session->data['success'] = $this->language->get('text_success_logs');
		}

		$this->redirect($this->url->link('module/evotor/log', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function getStoreUUID() {
		$json = array();

		if($this->request->get['tok']){
			$token = $this->request->get['tok'];

			$evotorStores = json_decode($this->getRequest($token));

			if ($evotorStores){

				if (isset($evotorStores->errors)){
					$err = '';
					foreach ($evotorStores->errors[0] as $key => $value) {
						$err .= $key . ' ' . $value . ' - ';
					}
					$json['suiid'][] = array('name' => $err, 'uiid' => 0);
				}
				else{
					$json['suiid'] = $evotorStores;
				}

			}
			else{
				$json['suiid'][] = array(
						'name' => 'Ошибка. Нет данных.',
						'uiid' => 0
				);
			}
		}
		else{
			$json['suiid'][] = array(
						'name' => 'Ошибка. Введите Токен приложения!',
						'uiid' => 0
				);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));	
	}

	private function getRequest ($token) {
    	$result = false;
    	$server = 'https://epsapi.akitorg.ru/api/v1/stores';
    	$headers = array(
					    'Content-Type: application/json',
					    'X-Authorization: '.$token
					);

    	if ( $curl = curl_init() ) {
					curl_setopt($curl, CURLOPT_URL, $server);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			        $result = curl_exec($curl);
			        curl_close($curl);
		}

		//if (!$result) {
		//	$result = file_get_contents($server);
		//}

		if ($result) {
			
			return $result;
			
		}
		else{
			$error = array(
				'name' => 'Ошибка. Нет подключения.',
				'uiid' => 0
			);
			return json_encode($error);
		}
    }
}
?>