<div id="todo-sticky-note" data-config="{{ $config }}"></div>

<script>
    (function (){
        var head = document.getElementsByTagName('head')[0];
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.type = 'text/css';
        link.href = '/vendor/sticky-todos/sticky-todos.css';
        link.media = 'all';
        head.appendChild(link);
        add js to body
        var body = document.getElementsByTagName('body')[0];
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = '/vendor/sticky-todos/sticky-todos.js';
        body.appendChild(script);
    })()
</script>