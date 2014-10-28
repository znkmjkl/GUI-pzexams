<?php

final class Settings
{
	public static function save()
	{
		$xmlDoc = new DOMDocument("1.0", "UTF-8");
		$xmlDoc->formatOutput = true;
		$xmlRoot = $xmlDoc->createElement("Settings");
		$xmlRoot = $xmlDoc->appendChild($xmlRoot);
		
		$xmlRoot->appendChild($xmlDoc->createElement("Adress", Settings::getAdress()));
		$xmlRoot->appendChild($xmlDoc->createElement("Debug", Settings::getDebug()));
		
		$xmlDomains = $xmlDoc->createElement("Domains");
		$domains = Settings::getDomains();
		foreach ($domains as $domain) {
			$xmlDomains->appendChild($xmlDoc->createElement("Domain", $domain));
		}
		$xmlRoot->appendChild($xmlDomains);
		
		$xmlEmail = $xmlDoc->createElement("Email");
		$xmlEmail->appendChild($xmlDoc->createElement("Adress", Settings::getEmailAdress()));
		$xmlEmail->appendChild($xmlDoc->createElement("Password", Settings::getEmailPassword()));
		$xmlEmail->appendChild($xmlDoc->createElement("Host", Settings::getEmailHost()));
		$xmlEmail->appendChild($xmlDoc->createElement("Port", Settings::getEmailPort()));
		$xmlRoot->appendChild($xmlEmail);
		
		$xmlAuthorization = $xmlDoc->createElement("Authorization");
		$xmlAuthorization->appendChild($xmlDoc->createElement("UseCode", Settings::getAuthorizationUseCode()));
		$xmlAuthorization->appendChild($xmlDoc->createElement("Code", Settings::getAuthorizationCode()));
		$xmlRoot->appendChild($xmlAuthorization);
		
		$file = fopen(Settings::getPath(), "w");
		fwrite($file, str_replace("  ", "\t", $xmlDoc->saveXML()));
		fclose($file);
	}
	
	public static function getDebug()
	{
		return self::getInstance()->debug;
	}
	
	public static function getDomains()
	{
		return self::getInstance()->domains;
	}
	
	public static function getPath()
	{
		return dirname(__FILE__) . "/../../cfg/Settings.xml";
	}
	
	public static function getAdress()
	{
		return self::getInstance()->adress;
	}
	
	public static function getEmailAdress()
	{
		return self::getInstance()->emailAdress;
	}
	
	public static function getEmailPassword()
	{
		return self::getInstance()->emailPassword;
	}
	
	public static function getEmailHost()
	{
		return self::getInstance()->emailHost;
	}
	
	public static function getEmailPort()
	{
		return self::getInstance()->emailPort;
	}
	
	public static function getAuthorizationUseCode()
	{
		return self::getInstance()->authorizationUseCode;
	}
	
	public static function getAuthorizationCode()
	{
		return self::getInstance()->authorizationCode;
	}
	
	// ------------------------------------------------------
	
	public static function setDebug($debug)
	{
		self::getInstance()->debug = $debug;
	}
	
	public static function setDomains($domains)
	{
		self::getInstance()->domains = $domains;
	}
	
	public static function setAdress($adress)
	{
		self::getInstance()->adress = $adress;
	}
	
	public static function setEmailAdress($emailAdress)
	{
		self::getInstance()->emailAdress = $emailAdress;
	}
	
	public static function setEmailPassword($emailPassword)
	{
		self::getInstance()->emailPassword = $emailPassword;
	}
	
	public static function setEmailHost($emailHost)
	{
		self::getInstance()->emailHost = $emailHost;
	}
	
	public static function setEmailPort($emailPort)
	{
		self::getInstance()->emailPort = $emailPort;
	}
	
	public static function setAuthorizationUseCode($authorizationUseCode)
	{
		self::getInstance()->authorizationUseCode = $authorizationUseCode;
	}
	
	public static function setAuthorizationCode($authorizationCode)
	{
		self::getInstance()->authorizationCode = $authorizationCode;
	}
	
	// ------------------------------------------------------
	
	private static function getInstance()
	{
		$cfgPath = dirname(__FILE__) . "/../../cfg/Settings.xml";
		
		if (self::$instance == false) {
			self::$instance = new Settings($cfgPath);
		}
		return self::$instance;
	}
	
	private function __construct($cfgPath)
	{
		$this->debug         = 0;
		$this->domains       = null;
		$this->adress        = "";
		$this->emailAdress   = "";
		$this->emailPassword = "";
		
		$this->__load($cfgPath);
	}
	
	private function __load($cfgPath)
	{
		if (!file_exists($cfgPath)) {
			echo "Nie udało się odnaleźść pliku \"" . $cfgPath . "\".\n";
			return;
		}
		
		$dom = new DOMDocument();
		$dom->load($cfgPath);
		$xml = simplexml_load_file($cfgPath);
		
		if ($dom->getElementsByTagName("Debug")->length > 0) {
			$debug = $xml->Debug;
			$this->debug = ($debug == 1 ? true : false);
		}
		
		if ($dom->getElementsByTagName("Domains")->length > 0) {
			$i = 0;
			foreach ($xml->Domains->Domain as $domain) {
				$this->domains[$i] = $domain;
				$i++;
			}
		}
		
		if ($dom->getElementsByTagName("Adress")->length > 0) {
			$this->adress = $xml->Adress;
		}
		
		if ($dom->getElementsByTagName("Email")->length > 0) {
			$this->emailAdress = $xml->Email->Adress;
			$this->emailPassword = $xml->Email->Password;
			$this->emailHost = $xml->Email->Host;
			$this->emailPort = (int)$xml->Email->Port;
		}
		
		if ($dom->getElementsByTagName("Authorization")->length > 0) {
			$useCode = $xml->Authorization->UseCode;
			$this->authorizationUseCode = ($useCode == 1 ? true : false);
			$this->authorizationCode = $xml->Authorization->Code;
		}
	}
	
	private $debug;
	private $domains;
	private $address;
	private $emailAdress;
	private $emailPassword;
	private $emailHost;
	private $emailPort;
	private $authorizationUseCode;
	private $authorizationCode;
	
	private static $instance = false;
}

?>
