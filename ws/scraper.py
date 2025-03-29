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

# 🔹 Configurar Selenium con ChromeDriver
options = webdriver.ChromeOptions()
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

def obtener_categoria_id(nombre_categoria):
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        cursor.execute("SELECT id FROM categorias WHERE nombre = %s", (nombre_categoria,))
        resultado = cursor.fetchone()
        if resultado:
            return resultado[0]
        else:
            cursor.execute("INSERT INTO categorias (nombre) VALUES (%s)", (nombre_categoria,))
            conn.commit()
            return cursor.lastrowid
    except mysql.connector.Error as err:
        print(f"❌ Error en MySQL: {err}")
        return None
    finally:
        cursor.close()
        conn.close()

def limpiar_precio(precio_texto):
    precio_texto = precio_texto.replace("$", "").replace(" ", "").replace(".", "").replace(",", ".").strip()
    try:
        return float(precio_texto) if precio_texto else 0.0
    except ValueError:
        print(f"❌ Error al convertir el precio: {precio_texto}")
        return 0.0

def scrape_inicio():
    driver.get("https://www.lavender.com.uy")
    time.sleep(3)
    
    NUMERO_LINKS = 5
    NUMERO = 0
    
    while NUMERO < NUMERO_LINKS:
        menu_catalogo_links_nivel1 = driver.find_element(By.ID, "menu_catalogo").find_elements(By.CLASS_NAME, "menu-nivel1")
        menu_catalogo_link_actual = menu_catalogo_links_nivel1[NUMERO].find_elements(By.TAG_NAME, "a")[0]
        categoria_nombre = menu_catalogo_link_actual.text.strip()
        categoria_id = obtener_categoria_id(categoria_nombre)
        menu_catalogo_link_actual.click()
        time.sleep(2)
        driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")

        lista_productos = driver.find_element(By.ID, "lista_productos")
        lista_contenedores_producto = lista_productos.find_elements(By.CLASS_NAME, "cont-producto")
        
        indice = 0
        for contenedor_producto in lista_contenedores_producto:
            if indice % 2 == 0:
                figure_producto = contenedor_producto.find_element(By.TAG_NAME, "figure")
                enlace_producto = figure_producto.find_element(By.TAG_NAME, "a").get_attribute("href")
                imagen_elemento = figure_producto.find_element(By.TAG_NAME, "a").find_element(By.TAG_NAME, "img")
                
                # 🔹 Mover a la imagen y esperar a que cargue
                driver.execute_script("arguments[0].scrollIntoView();", imagen_elemento)
                time.sleep(1)  # Esperar un segundo para asegurar que cargue la imagen
                
                imagen_url = imagen_elemento.get_attribute("data-src") or imagen_elemento.get_attribute("src")
                print(imagen_elemento.get_attribute("outerHTML"))  # 🔹 Verificar los atributos HTML de la imagen
                
                figcaption_producto = contenedor_producto.find_element(By.TAG_NAME, "figcaption")
                nombre_producto = figcaption_producto.find_element(By.TAG_NAME, "h3").find_element(By.TAG_NAME, "a").get_attribute("title")
                precio_producto = figcaption_producto.find_element(By.TAG_NAME, "h4").get_attribute("textContent").strip()
                precio_producto = limpiar_precio(precio_producto)
                
                print(f"Nombre: {nombre_producto}")
                print(f"Precio: {precio_producto}")
                print(f"Imagen URL: {imagen_url}")
                
                planta_id = guardar_planta(nombre_producto, "Descripción no disponible", precio_producto, imagen_url, categoria_id)
                if planta_id:
                    guardar_imagen(planta_id, imagen_url)
            
            indice += 1
        
        NUMERO += 1

def guardar_planta(nombre, descripcion, precio, imagen_url, categoria_id):
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        sql = """
        INSERT INTO plantas (nombre, descripcion, precio, imagen_url, categoria_id)
        VALUES (%s, %s, %s, %s, %s)
        """
        valores = (nombre, descripcion, precio, imagen_url, categoria_id)
        cursor.execute(sql, valores)
        conn.commit()
        return cursor.lastrowid
    except mysql.connector.Error as err:
        print(f"❌ Error al insertar planta: {err}")
        return None
    finally:
        cursor.close()
        conn.close()

def guardar_imagen(planta_id, imagen_url):
    try:
        conn = mysql.connector.connect(**db_config)
        cursor = conn.cursor()
        sql = "INSERT INTO imagenes (planta_id, imagen_url) VALUES (%s, %s)"
        cursor.execute(sql, (planta_id, imagen_url))
        conn.commit()
        print(f"✅ Imagen guardada para planta ID {planta_id}")
    except mysql.connector.Error as err:
        print(f"❌ Error al insertar imagen: {err}")
    finally:
        cursor.close()
        conn.close()

scrape_inicio()
driver.quit()
print("✅ Scraping completado")
