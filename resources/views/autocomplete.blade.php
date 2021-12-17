ПОДСКАЗКИ - {{$word}} <br />
@foreach($results as $word)
    {{ $word['word'] }},
@endforeach
