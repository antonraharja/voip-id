<?php

class PhoneNumberController extends \BaseController {

    /**
     * Instantiate a new DomainController instance.
     */
    public function __construct() {

        $this->beforeFilter('auth');
//        $this->beforeFilter('auth.admin');

    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        $phone_number = PhoneNumber::where('user_id',Auth::user()->id)->get();

        return View::make('phone_number.index')->with('phone_numbers', $phone_number);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getAdd()
	{
        if(PhoneNumber::where('user_id',Auth::user()->id)->count() >= Config::get('settings.phone_number_limit')){
            return Output::push(array(
                'path' => 'phone_number',
                'messages' => array('fail' => _('You have reached limit phone number')),
            ));
        }

        return View::make('phone_number.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postStore()
	{
        $input = Input::only('phone_number', 'description');
        $input['extension'] = rand(100,999);

        $rules = array(
            'phone_number' => 'required|unique:phone_numbers,phone_number',
            'extension' => 'unique:phone_numbers,extension',
        );
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return Output::push(array('path' => 'phone_number/add', 'errors' => $v, 'input' => TRUE));
        }

        $phone_number = new PhoneNumber([
            'user_id' => Auth::user()->id,
            'phone_number' => $input['phone_number'],
            'extension' => $input['extension'],
            'description' => $input['description'],
        ]);
        $phone_number->save();

        if ($phone_number->id) {
            return Output::push(array(
                'path' => 'phone_number',
                'messages' => array('success' => _('You have added Phone Number successfully')),
            ));
        } else {
            return Output::push(array(
                'path' => 'phone_number/add',
                'messages' => array('fail' => _('Fail to add Phone Number')),
                'input' => TRUE,
            ));
        }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function getEdit($id)
    {
        $phone_number = PhoneNumber::find($id);

        return View::make('phone_number.edit')->with('phone_number',$phone_number);
    }


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update($id)
    {
        $input = Input::only('phone_number', 'description');

        $rules = array(
            'phone_number' => 'required|unique:phone_numbers,phone_number,'.$id,
        );
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return Output::push(array('path' => 'phone_number/edit/'.$id, 'errors' => $v, 'input' => TRUE));
        }

        $domain = PhoneNumber::find($id);
        $domain->phone_number = $input['phone_number'];
        $domain->description = $input['description'];
        $domain->save();

        if ($id) {
            return Output::push(array(
                'path' => 'phone_number',
                'messages' => array('success' => _('You have updated phone number successfully')),
            ));
        } else {
            return Output::push(array(
                'path' => 'phone_number/edit/'.$id,
                'messages' => array('fail' => _('Fail to update phone number')),
                'input' => TRUE,
            ));
        }
    }


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function getDelete($id)
    {
        PhoneNumber::destroy($id);

        return Output::push(array(
            'path' => 'phone_number',
            'messages' => array('success' => _('Phone number  has been deleted'))
        ));
    }


}
