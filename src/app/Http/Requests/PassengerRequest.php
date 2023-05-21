<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class PassengerRequest extends Request {

    public function authorize()
    {
      return true;
    }

    public function rules()
    {
        $rules = [
            'email' => 'required|email',
            //'title' => 'required|max:255',
            //'firstName' => 'required',
            //'lastName' => 'required',
            //'gender' => 'required',
            //'dateOfBirth' => 'required|before:' . date('Y-m-d') . '|date_format:Y-m-d',
            //'passportNumber' => 'required',
            //'country' => 'required',
            //'nationality' => 'required',
            //'passportExpiryDate' => 'required',
        ];
        foreach($this->request->get('title') as $key => $val){
          $rules['title.'.$key] = 'required|max:10';
        }
        
        foreach($this->request->get('firstName') as $key => $val){
          $rules['firstName.'.$key] = 'required|max:255';
        }
        
        foreach($this->request->get('lastName') as $key => $val){
          $rules['lastName.'.$key] = 'required|max:255';
        }
        
        foreach($this->request->get('gender') as $key => $val){
          $rules['gender.'.$key] = 'required|max:10';
        }
        
        foreach($this->request->get('dateOfBirth') as $key => $val){
          $rules['dateOfBirth.'.$key] = 'required|before:' . date('d/m/Y') . '|date_format:d/m/Y';
        }
      return $rules;
    }
    
    public function messages()
    {
        $messages = [];
        foreach($this->request->get('title') as $key => $val){
            $messages['title.'.$key.'.required'] = 'The field passenger Title is required';
            $messages['title.'.$key.'.max'] = 'The field passenger Title '.$key.'" must be less than :max characters.';
        }
        
        foreach($this->request->get('firstName') as $key => $val){
            $messages['firstName.'.$key.'.required'] = 'The field passenger first name is required';
            $messages['firstName.'.$key.'.max'] = 'The field passenger first name '.$key.'" must be less than :max characters.';
        }
        
        foreach($this->request->get('lastName') as $key => $val){
            $messages['lastName.'.$key.'.required'] = 'The field passenger last name is required';
            $messages['lastName.'.$key.'.max'] = 'The field passenger last name '.$key.'" must be less than :max characters.';
        }
        
        foreach($this->request->get('gender') as $key => $val){
            $messages['gender.'.$key.'.required'] = 'The field passenger gender is required';
        }
        
        foreach($this->request->get('dateOfBirth') as $key => $val){
            $messages['dateOfBirth.'.$key.'.required'] = 'The field passenger date of birth is required';
            $messages['dateOfBirth.'.$key.'.date_format'] = 'The field passenger date of birth '.$key.'" must be in dd/mm/yyyy format.';
        }
        return $messages;
    }


}