$(() =>{

    $('[data-get]').on('click',e =>{
        e.preventDefault();
        const url = e.target.dataset.get;
        location = url||location;
    })

    $('[data-post]').on('click',e => {
        e.preventDefault();
        const url = e.target.dataset.post;
        const f = $('<form>').appendTo(document.body)[0];
        f.method = 'POST';
        f.action = url || location
        f.submit();
    })

    $('[type=reset]').on('click',e=>{
        e.preventDefault();
        location = location;
    })
})