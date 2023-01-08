<?php
# reDim GmbH - Norbert Bayer
# Plugin: CookieHint
# license GNU/GPL   www.redim.de
# Version 1.3.7
// No direct access
defined('JPATH_BASE') or die;

jimport( 'joomla.plugin.plugin' );

class plgSystemCookieHint extends JPlugin {

	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
	}
	
	public function onAfterDispatch() {

	    $app = JFactory::getApplication();

        if ($app->isAdmin() OR $app->input->getCMD('tmpl')=='component') {
			define('reDimCookieHint',1);
            return;
        }	
		
		$ch=$this->checkCookie();
		
		if($ch==0 OR $ch==-1) {
			if( $this->params->get('cookieblocker','0') == '1' ) {
				header_remove('Set-Cookie');
				JFactory::getDocument()->addScriptDeclaration($this->getHeadJava(true,true,true));
			}					
		}
	
		switch($app->input->getINT('rCH')) {

			case 2:
				$d=$this->getCookieTime();
				setcookie('reDimCookieHint', 1,$d,'/');
				$app->redirect(JURI::current());
			break;
			case -2:
				$d=$this->getCookieTime();
				setcookie('reDimCookieHint', -1,$d,'/');
				$app->redirect(JURI::current());
			break;		
		
			case 1:
				$d=$this->getCookieTime();
				setcookie('reDimCookieHint', 1,$d,'/');
				echo 'ok';
				$app->close();
			break;
			case -1:
				$d=$this->getCookieTime();
				setcookie('reDimCookieHint', -1,$d,'/');
				echo 'ok';
				$app->close();
			break;
		}

		if($ch==0) {
			
			$css=$this->params->get('css','style.css');
			$document = JFactory::getDocument();
			
			if($css!='-1'){
				#JHtml::_('jquery.framework');
				$document->addStyleSheet('plugins/system/cookiehint/css/'.$css,'text/css',"all");			
			}
			
			switch( $this->params->get('position','bottom') ) {
				
				case 'top':
				$inlinecss='#redim-cookiehint{top: 0px; bottom: auto !important;}';
				break;
				
				default:
				$inlinecss='#redim-cookiehint{bottom: 0px; top: auto !important;}';
				break;
				
			}
			
			$document->addStyleDeclaration($inlinecss);				
				
		}
	
	}	
	
	
	private function getCookieTime() {
		
		$cm=(int) $this->params->get('cookiemode');
		$d=(int) $this->params->get('cookieexpires',365);
		if($cm==1) {
			$d=0;
		}else{
			$d=time() + ($d*86400);
		}
		
		return $d;		
		
	}
	
	public function checkCookie() {

		if(defined('reDimCookieHint')) {
			return reDimCookieHint;
		}
		
		$app = JFactory::getApplication();
	
		$return=false;
		
		if($app->input->get('cookiehint')=='test') {
			@setcookie('reDimCookieHint', null, -1,0, '/');
			unset($_COOKIE['reDimCookieHint']);
		} 
		
		if(isset($_COOKIE['reDimCookieHint'])) {
			$return=$_COOKIE['reDimCookieHint'];
		}
		
		define('reDimCookieHint',$return);
		
		return reDimCookieHint;
		
	}
	
	public function onAfterRender()
	{
		
		if($this->checkCookie()==true) {
			return;
		}
		
		$buffer = JResponse::getBody();
		$html=$this->_get_code();
		if(  $buffer = preg_replace("/\<\/body(.*)>/", "\n" . $html . "\n$0", $buffer)) {
			JResponse::setBody($buffer);		
		}
	
	}
    
	public function onPageCacheGetKey() {
		$x=0;
		if(isset($_COOKIE['reDimCookieHint'])) {
			$x=$_COOKIE['reDimCookieHint'];
		}
		return 'reDimCookieHint'.$x;
	}	
	
	private function getURL($ar=array(),$url=null) {
		
		$uri = JURI::getInstance($url);	
		if(count($ar)>0) {
			$q=$uri->getQuery(true);
			$q=array_merge($q,$ar);
			$uri->setQuery($q);
		}
		return $uri->toString();		
	
	}
	
	public function _get_code() {
	
		$lang = JFactory::getLanguage();
 		$lang->load("plg_system_cookiehint",JPATH_ADMINISTRATOR);
		ob_start();
		$params=$this->params;

		$l=$lang->getTag();

		$refusal=(int) $params->get('refusal');
		if($refusal==2) {
			$refusalurl=trim( (string) $params->get('refusalurl','https://www.cookieinfo.org/'));	
			/*if(empty($refusalurl)) {
				$refusalurl = $this->getURL(array('reDimCookieHint'=>-1));
			}*/
		}else{
			$refusalurl='';
		}
		$link='';
		$links=$params->get('infourl',array());
		if(is_object($links)) {
			$links=(array) $links;
		}

		if(is_array($links)) {
			if(isset($links[$l])) {
				if(!empty($links[$l])) {
					$link=$links[$l];
				}
			}

			if(empty($link)) {
				if(count($links)>0) {
					foreach($links as $link) {
						if(!empty($link)) {
							break;
						}
					}
				}
			}
		}
		unset($links);

		$linkok=$this->getURL(array('rCH' => 2),JURI::current());
		$linknotok=$this->getURL(array('rCH' => -2),JURI::current());		
		
		$file=str_replace('/','',$params->get('file','default.php'));
	
		$temp=$l.'_'.$file;

		if(file_Exists(JPATH_SITE.'/plugins/system/cookiehint/include/'.$temp)) {
			$file=$temp;
		}else{		
			if(!file_exists(JPATH_SITE.'/plugins/system/cookiehint/include/'.$file)) {
				$file='default.php';
			}
		}
		
		include_once(JPATH_SITE.'/plugins/system/cookiehint/include/'.$file);

?>
<script type="text/javascript">
function cookiehintfadeOut(el){
  el.style.opacity = 1;

  (function fade() {
    if ((el.style.opacity -= .1) < 0) {
      el.style.display = "none";
    } else {
      requestAnimationFrame(fade);
    }
  })();
}  
<?PHP  
if($this->params->get('cookiemode')==0){
	$d=(int)$this->params->get('cookieexpires',365);
	$c=date('D, d M Y',time()+(86400 * $d)).' 23:59:59 GMT;';
	$c='reDimCookieHint=%s; expires='.$c;								
}else{
	$c='reDimCookieHint=%s; expires=0;';
}	
?>	
window.addEventListener('load',	
	function () {
		document.getElementById('cookiehintsubmit').addEventListener('click', function (e) {
			e.preventDefault();
			document.cookie = '<?PHP echo printf($c,1); ?>; path=/';
			cookiehintfadeOut(document.getElementById('redim-cookiehint'));
			return false;
		},false);
		<?PHP if($refusal==1): ?>
		document.getElementById('cookiehintsubmitno').addEventListener('click', function (e) {
			e.preventDefault();
			document.cookie = 'reDimCookieHint=-1; expires=0; path=/';
			cookiehintfadeOut(document.getElementById('redim-cookiehint'));
			return false;
		},false);		
		<?PHP endif; ?>
	}
);
</script>	
<?PHP 	
		return str_replace( array("\n","\r","\t","  "),' ',ob_get_clean());
	}
	
	private function getHeadJava($disableCookies=1,$disableLocal=1,$disableSession=1) {
	ob_start();		
?>
(function(){
	function blockCookies(disableCookies, disableLocal, disableSession){
		if(disableCookies == 1){
			if(!document.__defineGetter__){
				Object.defineProperty(document, 'cookie',{
					get: function(){ return ''; },
					set: function(){ return true;}
				});
			}else{	
				var oldSetter = document.__lookupSetter__('cookie');
				if(oldSetter) {
					Object.defineProperty(document, 'cookie', {
						get: function(){ return ''; },
						set: function(v){
							if(v.match(/reDimCookieHint\=/)) {
								oldSetter.call(document, v);
							}
							return true;
						}
					});
				}
			}
			var cookies = document.cookie.split(';');
			for (var i = 0; i < cookies.length; i++) {
				var cookie = cookies[i];
				var pos = cookie.indexOf('=');
				var name = '';
				if(pos > -1){
					name = cookie.substr(0, pos);
				}else{
					name = cookie;
				}
				if(name.match(/reDimCookieHint/)) {
					document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT';
				}
			}
		}	
		if(disableLocal == 1){	
			window.localStorage.clear();
			window.localStorage.__proto__ = Object.create(window.Storage.prototype);
			window.localStorage.__proto__.setItem = function(){ return undefined; };
		}
		if(disableSession == 1){	
			window.sessionStorage.clear();
			window.sessionStorage.__proto__ = Object.create(window.Storage.prototype);
			window.sessionStorage.__proto__.setItem = function(){ return undefined; };
		}
	}
	blockCookies(<?PHP echo $disableCookies; ?>,<?PHP echo $disableLocal; ?>,<?PHP echo $disableSession; ?>);
}());
<?PHP 
		return str_replace( array("\n","\r","\t","  "),' ',ob_get_clean());
		
	}
	
}
