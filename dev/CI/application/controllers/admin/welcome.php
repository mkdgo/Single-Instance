<?phpif (!defined('BASEPATH'))	exit('No direct script access allowed');
class Welcome extends MY_Controller {

	function __construct(){
		  parent::__construct();
	}

	function index(){

		$this->_paste_admin();
	}
        
}