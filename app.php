class Init
{		
	function __construct()
	{		
		$tpl = new HTML_Template_IT(DIR_APP .'app/views');	
		$tpl->loadTemplatefile('app.tpl.htm', true, true);	
		$session = new SecureSessionHandler('uniapp');
		$session->start();
		
		$c_action = "ClientesController";
		$m_action = "index";
		
		if(!empty($_GET['c']) and !empty($_GET['m']))
		{
			$c_action = $_GET['c'];
			$m_action = $_GET['m'];			
		}
		require_once DIR_APP ."app/controllers/". $c_action .".php";
		$obj = new $c_action;
		$act = $obj->$m_action();
		
		if(isset($obj->titulopage))
		$tpl->setVariable('TITULO',$obj->titulopage);
					
		if (!$this->isXmlHttpRequest())
		{		
			$tpl->setVariable('DATA', $act);				
			$tpl->show();
		}
	}
	
	function isXmlHttpRequest()
	{
		$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : null;
		return (strtolower($isAjax) === 'xmlhttprequest');
	}

}

//Inicializa a aplicação
$o= new Init();
