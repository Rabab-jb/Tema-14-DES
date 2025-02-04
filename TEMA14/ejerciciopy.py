import requests
from bs4 import BeautifulSoup

url = "https://es.wikipedia.org/wiki/Portal:Actualidad"

response = requests.get(url)

if response.status_code == 200:

    soup = BeautifulSoup(response.text, "html.parser")

    seccion_actualidad = soup.find("div", class_="mw-parser-output")

    if seccion_actualidad:
       
        titulos = seccion_actualidad.find_all("li")

        print("📢 Títulos de actualidad en Wikipedia 📢\n")
        for titulo in titulos:
            enlace = titulo.find("a") 
            if enlace and enlace.text:
                print("-", enlace.text.strip())

    else:
        print("No se encontró la sección de 'Actualidad' en la página.")

else:
    print(f"Error al acceder a la página. Código de estado: {response.status_code}")
