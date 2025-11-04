<h2>New Feedback Received</h2>

<p><strong>Message:</strong> {{ $data['message'] }}</p>

@if(!empty($data['name']))
    <p><strong>Name:</strong> {{ $data['name'] }}</p>
@endif

@if(!empty($data['email']))
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
@endif