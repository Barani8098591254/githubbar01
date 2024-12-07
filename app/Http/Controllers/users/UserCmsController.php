<?php

namespace App\Http\Controllers\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\contact_us;
use App\Models\Plan;





class UserCmsController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }

    public function aboutus()
    {
        $data['title'] = 'About Us';
        $data['js_file'] = '';
        $data['pageTitle'] = 'About Us';
        $data['subTitle'] = 'About Us';
        return view('user/CMS/aboutus', $data);
    }

    public function investPlan()
    {
        $data['title'] = 'Invest Plan';
        $data['js_file'] = '';
        $data['pageTitle'] = 'Invest Plan';
        $data['subTitle'] = 'Invest Plan';
        $data['planList'] = Plan::where('status', 1)->get();
        return view('user/CMS/plan', $data);
    }

    public function affiliate()
    {


        $data['title'] = 'Affiliate';
        $data['js_file'] = '';
        $data['pageTitle'] = 'Affiliate';
        $data['subTitle'] = 'Affiliate';
        return view('user/CMS/affiliate', $data);
    }

    public function contactus()
    {
        $data['title'] = 'Contact Us';
        $data['js_file'] = 'auth';
        $data['pageTitle'] = 'Contact Us';
        $data['subTitle'] = 'Contact Us';
        return view('user/CMS/contact', $data);
    }

    public function termsofservice()
    {
        $data['title'] = 'Terms Of Service';
        $data['js_file'] = '';
        $data['pageTitle'] = 'Terms Of Service';
        $data['subTitle'] = 'Terms Of Service';
        return view('user/CMS/termsofservice', $data);
    }

    public function privacyPolicy()
    {
        $data['title'] = 'Privacy Policy';
        $data['js_file'] = '';
        $data['pageTitle'] = 'Privacy Policy';
        $data['subTitle'] = 'privacy Policy';
        return view('user/CMS/privacyPolicy', $data);
    }

    public function refundPolicy()
    {
        $data['title'] = 'Refund Policy';
        $data['js_file'] = '';
        $data['pageTitle'] = 'Refund Policy';
        $data['subTitle'] = 'Refund Policy';
        return view('user/CMS/refundPolicy', $data);
    }



    public function contactmail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $contact = new contact_us();
        $contact->name = strip_tags($request->name);
        $contact->email = strip_tags($request->email);
        $contact->subject = strip_tags($request->subject);
        $contact->message = strip_tags($request->message);
        $result = $contact->save();


        if ($result) {
            // $user_id = Session::get('userId');
            $name = $request->name;
            $email = $request->email;
            $subject = $request->subject;
            $content = $request->message;

            // $send = send_mail(5, 'gurumoorthi@biovustech.com', 'contactus', [

            $send = send_mail(5, trim(strip_tags($email)), 'Contact Us', [

                '###USERNAME###' => $name,
                '###USEREMAIL###' => $email,
                '###subject###' => $subject,
                '###MESSAGE###' => $content,
                '###COPY###' => 'Copyright © 2023 mlm all rights reserved.'
            ]);



            return back()->with('success', 'Your request has been sent to admin. admin will contact you soon !!!');
        } else {
            return back()->with('fail', 'Contact information');
        }
    }
}
