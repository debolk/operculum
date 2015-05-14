<?php
/**
 * @uri /person/:uid
 */
class PersonController extends Tonic\Resource
{
    /**
     * Check if the user can access an access level resource
     * @param  Tonic\Resource $resource can be any valid access level resource
     *                                  bekend (default), bestuur, ictcom, lid or mp3control
     * @return boolean
     */
    public function loggedIn($resource = 'bekend')
    {
        return OAuth2Helper::isAuthorisedFor($resource);
    }

    /**
     * @method GET
     * @loggedIn lid
     * Returns json representation of person
     */
    public function getPerson($uid)
    {
        $person = Person::find_by_uid($uid);
        if(!$person)
            return new Tonic\Response(404, '{"error":"invalid_uid", "error_description": "The requested uid was not found"}');

        return $person->to_json();
    }

		/**
		 * @method OPTIONS
		 * Returns acceptible methods
		 */
		public function options($uid)
		{
			$response = new Tonic\Response(200, "");
			$response->Allow = "GET,HEAD,PUT,PATCH";
			$response->AccessControlAllowMethods = "GET,HEAD,PUT,PATCH";
			return $response;
		}

    /**
     * @method PUT
     * @loggedIn bestuur
     * Replaces the person with new data
     */
    public function putPerson($uid)
    {
        $data = json_decode($this->request->data);
        if(!$data)
            return new Tonic\Response(400, '{"error":"bad_request","error_description":"The json data could not be parsed"};');

				if(!isset($data->uid))
					$data->uid = $uid;

        if($data->uid != $uid)
            return new Tonic\Response(400, '{"error":"validation_error","error_description":["Uid is not the same as resource uid"]}');

        $person = new Person;
        foreach($data as $key => $value)
            if(isset($person->$key))
						{
                $person->$key = $value;
								if($person->$key == null && !empty($value))
									return new Tonic\Response(400, '{"error":"validation_error","error_description":["' . $key . ' is not valid!"]}');
						}

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
     * Changes a few attributes of a person
     */
    public function patchPerson($uid)
    {
        $person = Person::find_by_uid($uid);
        if(!$person)
            return new Tonic\Response(404, '{"error":"invalid_uid", "error_description": "The requested uid was not found"}');

        $data = json_decode($this->request->data);
        if(!$data)
            return new Tonic\Response(400, '{"error":"bad_request","error_description":"The json data could not be parsed"};');

        if(isset($data->uid) && $data->uid != $uid)
            return new Tonic\Response(400, '{"error":"validation_error","error_description":["Uid is not the same as resource uid"]}');

        //Set values
        foreach($data as $key => $value)
            if(isset($person->$key))
						{
                $person->$key = $value;
								if($person->$key == null && !empty($value))
									return new Tonic\Response(400, '{"error":"validation_error","error_description":["' . $key . ' is not valid!"]}');
						}

        if(!$person->is_valid())
            return new Tonic\Response(400, '{"error":"validation_error","error_description":' . json_encode($person->errors->full_messages()) . '}');

        $person->save();
        return $person->to_json();
    }
}
