public function getPlantsByCategory($categoryName) {
    $sql = "SELECT 
                p.id, p.nombre, p.descripcion, p.precio, p.imagen_url, 
                c.nombre AS categoria,
                (SELECT GROUP_CONCAT(im.imagen_url) FROM imagenes im WHERE im.planta_id = p.id) AS imagenes
            FROM plantas p
            JOIN categorias c ON p.categoria_id = c.id
            WHERE c.nombre = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$categoryName]);
    $plants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convertir la cadena de imágenes en un array
    foreach ($plants as &$plant) {
        $plant['imagenes'] = $plant['imagenes'] ? explode(',', $plant['imagenes']) : [];
    }

    return $plants;
}
