from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import mysql.connector
import time

# 🔹 Configuración de MySQL
db_config = {
    'host': '127.0.0.1',
    'user': 'usuario',
    'password': 'Leticia11-11',
    'database': 'usuarios'
}

# 🔹 Lista de categorías con sus URLs
categorias_urls = {

    "Inicio": "https://www.lavender.com.uy",
    "Plantas Anuales": "https://www.lavender.com.uy/plantas-anuales/n1_1/",
    "Plantas Perennes": "https://www.lavender.com.uy/plantas-perennes/n1_2/",
    "Herbáceas": "https://www.lavender.com.uy/herbaceas/n2_2/",
    "Suculentas": "https://www.lavender.com.uy/suculentas/n2_3/",
    "Arbustos": "https://www.lavender.com.uy/arbustos/n1_3/",
    "Trepadores": "https://www.lavender.com.uy/trepadores/n2_6/",
    "Rosales": "https://www.lavender.com.uy/rosales/n2_16/",
    "Árboles": "https://www.lavender.com.uy/arboles/n1_4/",
    "Frutales": "https://www.lavender.com.uy/frutales/n2_7/",
    "Palmeras": "https://www.lavender.com.uy/palmeras/n2_8/"
}

# 🔹 Configurar Selenium con ChromeDriver
options = webdriver.ChromeOptions()
# options.add_argument("--headless")  # Ejecutar en modo oculto (sin abrir el navegador)
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

# 🔹 Función para extraer datos de una categoría
#def scrape_categoria(url, categoria):
def scrape_inicio() :
    
    driver.get("https://www.lavender.com.uy")
    time.sleep(3)  # Esperar que la página cargue

    NUMERO_LINKS = 5;
    NUMERO = 0;
    while NUMERO < NUMERO_LINKS :
        menu_catalogo_links_nivel1 = driver.find_element(By.ID, "menu_catalogo").find_elements(By.CLASS_NAME, "menu-nivel1")
        menu_catalogo_link_actual = menu_catalogo_links_nivel1[NUMERO].find_elements(By.TAG_NAME, "a")[0]
        menu_catalogo_link_actual.click()
        time.sleep(2)

        lista_productos = driver.find_element(By.ID, "lista_productos")

        lista_contenedores_producto = lista_productos.find_elements(By.CLASS_NAME, "cont-producto")

        for contenedor_producto in lista_contenedores_producto :
            figure_producto = contenedor_producto.find_element(By.TAG_NAME, "figure")
            print(figure_producto.find_element(By.TAG_NAME, "a").get_attribute("href"))
            print(figure_producto.find_element(By.TAG_NAME, "a").find_element(By.TAG_NAME, "img").get_attribute("src"))
            figcaption_producto = contenedor_producto.find_element(By.TAG_NAME, "figcaption")
            print(figcaption_producto.find_element(By.TAG_NAME, "h3").find_element(By.TAG_NAME, "a").get_attribute("title"))
            print(figcaption_producto.find_element(By.TAG_NAME, "h4").text)      

        NUMERO = NUMERO + 1  



# 🔹 Función para guardar los datos en MySQL
def guardar_en_mysql(datos):
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()

        sql = """
        INSERT INTO plantas (nombre, descripcion, precio, imagen_url, categoria)
        VALUES (%s, %s, %s, %s, %s)
        """
        cursor.executemany(sql, datos)
        conn.commit()

        print(f"✅ Se han insertado {cursor.rowcount} registros en la base de datos.")

    except mysql.connector.Error as err:
        print(f"❌ Error en la base de datos: {err}")
    finally:
        cursor.close()
        conn.close()




scrape_inicio()
# 🔹 Ejecutar el scraping en todas las categorías
#for categoria, url in categorias_urls.items():
#    print(f"🔎 Scrapeando categoría: {categoria}...")
#    datos = scrape_categoria(url, categoria)
#    
#    if datos:
#        guardar_en_mysql(datos)
#    else:
#        print(f"⚠️ No se encontraron productos en {categoria}")

driver.quit()
print("✅ Scraping completado")

