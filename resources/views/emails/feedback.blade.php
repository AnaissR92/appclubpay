@extends('emails.layout')
@section('body')
    @php($lbl_email = __('system.fields.email'))
    @php($lbl_name = __('system.feedbacks.name'))
    @php($lbl_message = __('system.feedbacks.message'))
    @php($lbl_restaurant_name = __('system.fields.restaurant_name'))
    @php($feedback_email_content = __('system.feedbacks.feedback_email_content'))
    <table style="color: #000; width: 100%;" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table style="color: #000; width: 100%;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="text-align: left; padding: 40px 30px;">
                            <h2 style="font-size: 24px; font-weight: 700;margin: 0 0 20px;text-align: left;">{{__('system.feedbacks.hey')}} {{$vendor_name}},</h2>
                            <p style="font-size: 14px; line-height: 22px;margin: 0 0 20px;text-align: left;">{{$feedback_email_content}}</p>

                            <hr style="margin-bottom: 20px;" />
                            <h3 style="font-size: 16px; font-weight: normal;margin: 0 0 10px;"><b>{{$lbl_restaurant_name}}</b>: {{ $restaurant_name }}</h3>
                            <h3 style="font-size: 16px; font-weight: normal;margin: 0 0 10px;"><b>{{$lbl_name}}</b>: {{ $name }}</h3>
                            <h3 style="font-size: 16px; font-weight: normal;margin: 0 0 10px;"><b>{{$lbl_email}}</b>: {{ $email }}</h3>
                            <h3 style="font-size: 16px; font-weight: normal;margin: 0 0 10px;"><b>{{$lbl_message}}</b>: {{ $user_message }}</h3>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
