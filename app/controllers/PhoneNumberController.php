<?php

class PhoneNumberController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        $phone_number = PhoneNumber::all();

        return View::make('phone_number.index')->with('phone_numbers', $phone_number);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getAdd()
	{
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
        $input['account'] = rand(100,999);

        $rules = array(
            'phone_number' => 'required|unique:phone_numbers,phone_number',
            'account' => 'unique:phone_numbers,account',
        );
        $v = Validator::make($input, $rules);
        if ($v->fails()) {
            return Output::push(array('path' => 'phone_number/add', 'errors' => $v, 'input' => TRUE));
        }

        $phone_number = new PhoneNumber([
            'user_id' => Auth::user()->id,
            'phone_number' => $input['phone_number'],
            'account' => $input['account'],
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
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
