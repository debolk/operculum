<?php
class Person extends ActiveRecord\Model
{
    static $validates_precense_of = array(
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

        return json_encode($data);
    }
}
