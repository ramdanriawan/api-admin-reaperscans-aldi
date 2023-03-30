<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload' => 'required|mimes:jpg,jpeg,png,bmp|max:5000',
        ]);

        if ($validator->fails()) {
            $error = implode(",", collect($validator->errors())->toArray()['upload']);

            return "<script>window.parent.CKEDITOR.tools.callFunction($request->CKEditorFuncNum, '', '$error')</script>";
        }

        $upload_destination = 'uploads/' . $request->upload->getClientOriginalName();
        $request->upload->move('uploads', $upload_destination);
        $url = url($upload_destination);

        return "<script>window.parent.CKEDITOR.tools.callFunction($request->CKEditorFuncNum, '$url', 'Success')</script>";
    }
}
