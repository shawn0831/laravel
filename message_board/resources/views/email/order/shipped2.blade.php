@component('mail::message')
# Introduction

The body of your message.

<!-- Writing Markdown Messages -->
<!-- ============================================================= -->
<!-- Button Component -->
@component('mail::button', ['url' => '','color' => 'success'])
Button Text
@endcomponent

<!-- Panel Component -->
@component('mail::panel')
This is the panel content
@endcomponent

<!-- Table Component -->
@component('mail::table')
| Laravel  | Table         | Example |
| -------- |:-------------:|:-------:|
| Col 2 is | Centered      | $10     |
| Col 3 is | Right-Aligned | $20     |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
