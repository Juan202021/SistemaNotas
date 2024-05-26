getData()

document.getElementById("Buscador").addEventListener("keyup",getData)

function getData(){
    let data = document.getElementById("Buscador").value
    let content = document.getElementById("content")
    let id = document.getElementById("Buscador").tagName
    let url = "loader.php?cod_doc=" + id + "&nomb_cur=" + data
    let formaData = new FormData()
    formaData.append("cod_doc",id)
    formaData.append("nomb_cur",data)

    fetch( url,{
        method: "GET",
        body: formaData
    }).then(response => response.json)
    .then(data => {
        content.innerHTML = data
    }).catch(err => console.log(err))
}