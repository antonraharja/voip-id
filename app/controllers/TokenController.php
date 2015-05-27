<?php

class TokenController extends BaseController {

	public function getIndex(){
		
		$tokens = Token::where('user_id', Auth::user()->id)->get();
        return View::make('token.index')->with('tokens', $tokens);
	}
	
	public function getAdd()
	{
        $token = new Token;
        $token->token = Hash::make('koplok');
        $token->user_id = Auth::user()->id;
        $token->save();
        return Output::push(array(
							'path' => 'token',
							'messages' => array('success' => _('Token was created')),
							));
	}
	
	public function postIndex()
	{
		$input = Input::only('keyword');
		$rules = array(
			'keyword' => 'required|min:6',
		);
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			return Output::push(array(
				'path' => 'token',
				'errors' => $v,
				'input' => TRUE,
				));
		}
		
        $token = new Token;
        $token->token = Hash::make($input['keyword']);
        $token->user_id = Auth::user()->id;
        $token->save();
        return Output::push(array(
							'path' => 'token',
							'messages' => array('success' => _('Token was created')),
							));    
	}
	
	public function getDelete($id)
	{
        $token = Token::find($id);
        $token->delete();
        
        return Output::push(array(
            'path' => 'token',
            'messages' => array('success' => _('Token has been deleted'))
        ));
	}
}
