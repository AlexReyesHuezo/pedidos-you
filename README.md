# Pedidos You

Es un proyecto que implementa consultas a una base de datos MySQL con consultas de Query Builder, basado en el diagrama de entidad-relación mostrado abajo. El objetivo es gestionar los datos relacionados a los pedidos de productos de los usuarios.

## Diagrama Entidad-Relación
erDiagram
    USUARIOS {
        int Id PK
        string nombre
        string correo
        string telefono
    }

    PEDIDOS {
        int Id PK
        string producto
        int cantidad
        float total
        int id_usuario FK
    }

    USUARIOS ||--o{ PEDIDOS : tiene

    Usuarios "1" --> "0..*" Pedidos : Contiene
end


## License

El proyecto es de código abierto licenciado [GPL-3.0 license](https://www.gnu.org/licenses/gpl-3.0.html).
