<!DOCTYPE html>
<html>
<head>
    <title>{{ $page->seo_content->meta_title ?? 'Default Title' }}</title>
</head>
<body>
    <h1>{{ $page->title }}</h1>
    <div>{!! $page->content !!}</div>
</body>
</html>