<?php
/**
 *
 */
class JudgerServer
{
    public $DB = "assist/db/db.json";
    public $JudgerUrl = "https://github.com/coderoj-dev/Judger";

    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
    }

    public function getJudgerList()
    {
        $data = file_get_contents($this->DB);
        $data = json_decode($data, true);
        return $data;
    }

    public function updateDB($data)
    {
        exec("chmod -R 777 assist");
        file_put_contents($this->DB, json_encode($data));
    }

    public function resetJudger(){
    	$data = $this->getJudgerList();
    	foreach ($data as $key => $value) {
    		$this->deleteJudger($value['name']);
    	}

    	$data = [];
    	$this->updateDB($data);

    	return [
			'error'    => 0,
            'errorMsg' => "Successfully Reset Judger",
    	];
    }

    public function getRandomString($len=10){
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $randomString = "";
        for ($i = 0; $i < $len; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        }
        return $randomString;
    }

    public function createJudger()
    {
        $data = $this->getJudgerList();

        if(count($data) > 20) return [
        	'error' => 1,
        	'errorMsg' => 'Judger Limit Cross'
        ];

        $randString = $this->getRandomString();
        $newJudgerName = "judger-$randString";

        while (isset($data[$newJudgerName])) {
        	$randString = $this->getRandomString();
        	$newJudgerName = "judger-$randString";
        }

        $judgerPath = "judger/$newJudgerName";

        exec("chmod -R 777 judger");
        $response = shell_exec("git clone ".$this->JudgerUrl." $judgerPath");

        $data[$newJudgerName] = [
            'name'    => $newJudgerName,
            'created' => date("Y-m-d H:i:s", time()),
        ];

        $this->updateDB($data);

        return [
            'error'    => 0,
            'errorMsg' => "Successfully Created New Judger",
        ];
    }

    public function deleteJudger($judgerName)
    {
    	$data = $this->getJudgerList();
    	$judgerKey = -1;

    	unset($data[$judgerName]);
    	$this->updateDB($data);
    	shell_exec("rm -rf judger/$judgerName");
    	return [
            'error'    => 0,
            'errorMsg' => "Successfully Deleted Judger",
        ];
    }
}
