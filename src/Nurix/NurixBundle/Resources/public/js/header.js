function del()
{

    if(document.forma.poisk.value=='Поиск...')
    {
        document.forma.poisk.value='';
    }
}
function dob()
{
    if(document.forma.poisk.value=='')
    {
        document.forma.poisk.value='Поиск...';
    }
}
function delete_value()
{

    if(document.forma2.podpiska.value==' Введите ваш электронный адрес')
    {
        document.forma2.podpiska.value='';
    }
}
function add_value()
{
    if(document.forma2.podpiska.value=='')
    {
        document.forma2.podpiska.value=' Введите ваш электронный адрес';
    }
}