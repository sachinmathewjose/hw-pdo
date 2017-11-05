<?php 
$program =new main();

class main
{
	static public $html = '';
	public function __construct()
	{
		self::$html .= "<html><head>PDO Practice:<br> <style>table, th, td {border: 1px solid black;";
   		self::$html .= "border-collapse: collapse;}</style></head><body>";
		$account = new accounts;
		$table = $account->selectAll("`id`<6");
		$count = sizeof($table);
		self::$html .= "the number of output raws: $count<br>";
		if ($count > 0)
		{
			self::$html .= table::print_table($table);
		}
	}
	public function __destruct()
	{
		self::$html .= '</body></html>';
		echo self::$html;
	}
}

class table
{
	static public function print_table($table)
	{
		$string = '<table > <tr>';
		foreach (array_flip($table[0]) as $value)
		{
			$string .= "<th>$value</th>";
		}
		$string .= '</tr>';
		foreach ($table as $raw)
		{
			$string .= '<tr>';
			foreach ($raw as $entry)
			{
				$string .= "<td>$entry</td>";
			}
			$string .= '</tr>';
		}
		$string .= "</table>";
		return $string;
	}
}
class dbConnection
{ 
	//variable to hold connection object.
	protected static $db;
	private static $hostname = "sql2.njit.edu";
	private static $username = "sj555";
	private static $password = "mYSZqqZ9S";
	private static $dbname = "sj555";
	//private constructor.
	private function __construct() 
	{   
		   try 
		   {
			   	// assign PDO object to db variable
			   	self::$db = new PDO("mysql:host=".self::$hostname.";dbname=".self::$dbname,self::$username, self::$password);
			   	self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			   	main::$html .= "Connected successfully<br>";
		   }
		   catch (PDOException $e) 
		   {
			   //Output error - would normally log this to error file rather than output to user.
			   main::$html .= "Connection Error: " . $e->getMessage()."<br>";
		   }
	}
	     
     // get connection function, returns the oject of this class
    static public function getConnection()
    {
      
	    //Guarantees single instance, if no connection object exists then create one.
	    if (!self::$db)
	    {
	      //new connection object.
	      new dbConnection();
	    }   
	    //return existing connection.
	    return self::$db;
	}
}

class accounts
{
	static public function selectAll($condition = '')
	{
		$table = get_called_class();
		if($condition)
		{
			$condition = 'WHERE' . $condition;
		}
		$sql = "select * from ".$table." ". $condition;

        $db = dbConnection::getConnection();
        $statement = $db->prepare($sql);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $recordsSet =  $statement->fetchAll();
        return $recordsSet;
    }

}



 ?>