<?php
/**
 * @uri /person/:uid
 */
class PersonController extends Tonic\Resource
{
    public function loggedIn($resource)
    {
        $unauthorized = OAuth2Helper::IsUnauthorized('bestuur');
        if($unauthorized)
            return $unauthorized;
        return true;
    }

    /**
     * @method GET
     */
    public function getPerson($uid)
    {
        $person = Person::find_by_uid($uid);
        if(!$person)
            return new Tonic\Response(404, '{"error":"invalid_uid", "error_description": "The requested uid was not found"}');

        return $person->to_json();
    }

    /**
     * @method PUT
     * @loggedIn bestuur
     */
    public function putPerson($uid)
    {
        $data = json_decode($this->request->data);
        if(!$data)
            return new Tonic\Response(400, '{"error":"bad_request","error_description":"The json data could not be parsed"};');

        if($data->uid != $uid)
            return new Tonic\Response(400, '{"error":"validation_error","error_description":["Uid is not the same as resource uid"]}');

        $person = new Person;
        foreach($data as $key => $value)
            if(isset($person->$key))
                $person->$key = $value;

        if(!$person->is_valid())
            return new Tonic\Response(400, '{"error":"validation_error","error_description":' . json_encode($person->errors->full_messages()) . '}');

        $old = Person::find_by_uid($uid);
        if($old)
            $old->delete();
        $person->save();
        return $person->to_json();
    }

    /**
     * @method PATCH
     * @loggedIn bestuur
     */
    public function patchPerson($uid)
    {
        $person = Person::find_by_uid($uid);
        if(!$person)
            return new Tonic\Response(404, '{"error":"invalid_uid", "error_description": "The requested uid was not found"}');

        $data = json_decode($this->request->data);
        if(!$data)
            return new Tonic\Response(400, '{"error":"bad_request","error_description":"The json data could not be parsed"};');

        if(isseT($data->uid) && $data->uid != $uid)
            return new Tonic\Response(400, '{"error":"validation_error","error_description":["Uid is not the same as resource uid"]}');

        //Set values
        foreach($data as $key => $value)
            if(isset($person->$key))
                $person->$key = $value;
        
        if(!$person->is_valid())
            return new Tonic\Response(400, '{"error":"validation_error","error_description":' . json_encode($person->errors->full_messages()) . '}');

        $person->save();
        return $person->to_json();
    }
}