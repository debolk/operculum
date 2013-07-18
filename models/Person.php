<?php
class Person extends ActiveRecord\Model
{
    static $validates_presence_of = array(
        array('uid'),
        array('alive')
    );

    static $validates_size_of = array(
        array('uid', 'within' => array(1,255))
    );

    static $validates_inclusion_of = array(
        array('alive', 'in' => array(0, 1))
    );

    public function to_json(array $options = array())
    {
        $data = $this->to_array();
        foreach($data as $key => $value)
            if($value == null)
                unset($data[$key]);

        $data['alive'] = @$data['alive']?true:false;
				
				// Format dates as yyyy-mm-dd
				$fields = array('inauguration', 'resignation_letter', 'resignation');
				foreach($fields as $field)
					if(isset($data[$field]))
						$data[$field] = strftime('%Y-%m-%d', strtotime($data[$field]));

        return json_encode($data);
    }
}
