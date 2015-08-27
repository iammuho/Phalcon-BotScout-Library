<?php
/**
 * For Phalcon BotScout Library (BotScout.com)
 *
 * @package     Mars Social
 * @author		Muhammet ARSLAN (http://github.com/geass/)
 * @version		1.0
 */
 

 
class BotScout extends Phalcon\Mvc\User\Component 
{

	//use diagnostic output? ('1' to use, '0' to suppress)
	private $diag = '0';

	//send email notices when a bot is stopped?
	private $send_alerts = '0'; 

	// if sending alerts, send them to what email address?
	private $toText = "muhammet.arsln@gmail.com";

	//Get the IP Address
	private $XIP;

	//Form fields
	private $XUSER;
	private $XMAIL;

	//Api Query
	private $apiquery;


	//API Key
	private $APIKEY;


	/**
	* BotScout construction for first time
	*
	* @param array $data data for botscout construction
	*/

	 public function __construct($data=array())
    {
        $this->XUSER = $data['username'];
        $this->XMAIL = $data['email'];
        $this->APIKEY = $this->config->botscout->api_key;
		$this->XIP 	= ($this->config->application->status == "Development") ? $this->config->botscout->test_ip : $_SERVER['REMOTE_ADDR'];
		$this->apiquery = "http://botscout.com/test/?multi&mail=".$this->XMAIL."&ip=".$this->XIP;

    }


    /**
	* We are checking post parameters to decide whether this is bot or not
    */
    public function checkBot()
    {


    	$outputData = $this->getData();


    	$this->diag($outputData);

		$botdata = explode('|', $outputData);

		//echo "<pre>"; print_r($outputData); die();
		// $botdata[0] - 'Y' if found in database, 'N' if not found, '!' if an error occurred 
		// $botdata[1] - type of test (will be 'MAIL', 'IP', 'NAME', or 'MULTI') 
		// $botdata[2] - descriptor field for item (IP)
		// $botdata[3] - how many times the IP was found in the database 
		// $botdata[4] - descriptor field for item (MAIL)
		// $botdata[5] - how many times the EMAIL was found in the database 
		// $botdata[6] - descriptor field for item (NAME)
		// $botdata[7] - how many times the NAME was found in the database 


		if(substr($outputData, 0,1) == '!' or $botdata[0] == '!'){
		// if the first character is an exclamation mark, an error has occurred  
		print "Error: $outputData";
		exit;
		}


		if($botdata[0] == 'Y')
		{
			//if the botdata returns "Y" (meaning YES! There is bot attack)

			print "This is bot attack";
			exit;
		}

    }


    /**
	* Getting data from $this->api_query url
	*
	* @return text/html/json $returned_data return data from $this->api_query
    */
    private function getData()
    {
		

		if(function_exists('file_get_contents')){
			
			$returned_data = file_get_contents($this->apiquery);

		}else{

			$ch = curl_init($this->apiquery);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$returned_data = curl_exec($ch);
			curl_close($ch);

		}


		return $returned_data;


    }


    /**
	* Diagnostic output data (from $this->diag value)
	* 
	* @param string/html/json $outputData OUTPUTDATA from $this->api_query content
    */
    private function diag($outputData)
    {

    	if($this->diag=='1'){

			if($outputData == ''){
				print 'Error: No return data from API query.';
				exit;
			}else{
				print "API Data: $outputData <br>";
			}

		}


	}




}