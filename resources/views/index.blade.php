<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>E - doctor</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:500'>
<link rel="stylesheet" href="{{asset('css/land.css')}}">
<link rel="stylesheet" href="{{asset('css/arrow.css')}}">
<script src="{{asset('js/widget.js')}}"></script>


</head>
<body>
<!-- partial:index.partial.html -->
<section class='intro'>
<div class="scroll-prompt" scroll-prompt="" ng-show="showPrompt" style="opacity: 1;">
    <div class="scroll-prompt-arrow-container">
        <div class="scroll-prompt-arrow"><div></div></div>
        <div class="scroll-prompt-arrow"><div></div></div>
    </div>
</div>
  <div class='intro__text'>E - doctor</div>
  <br><br>
  <form action="/login">
  <button class='intro__btn' type='submit'>Doctor Login</button>
  </form>
</section>
<!-- partial -->
  <script  src="{{asset('js/land.js')}}"></script>

</body>
</html>