package Main;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.Properties;

/**
 * Classe permettant de se connecter à la base de données
 * @author prugne2u
 */

public class DBConnection {
	
	private static Connection connection;
	private static String userName = "prugne2u";
	private static String password = "12345";
	private static String serverName = "webetu.iutnc.univ-lorraine.fr";
	private static String portNumber = "3306";
	private static String dbName = "prugne2u";
	private static String urlDB = "jdbc:mysql://" + serverName + ":" +portNumber +"/" + dbName;
	private static Properties connectionProps = new Properties();
	
	private DBConnection() {}
	
	/**
	 * Methode getConnection
	 * @return
	 * 			Une connection
	 * @throws SQLException
	 * 			Exception SQL
	 * @throws ClassNotFoundException 
	 */
	
	public static synchronized Connection getConnection() throws SQLException, ClassNotFoundException
	{
		if(connection == null) {
			Class.forName("com.mysql.jdbc.Driver");
			connectionProps.put("user", userName);
			connectionProps.put("password", password);
			connection = DriverManager.getConnection(urlDB, connectionProps);
		}
		return connection;	
	}
	
	/**
	 * Methode setNomDB
	 * Permet de renommer la base de données
	 * @param nomDB
	 * 				Le nom de la base
	 * @throws SQLException
	 * 				Exception SQL
	 * @throws ClassNotFoundException 
	 */
	
	public static void setNomDB(String nomDB) throws SQLException, ClassNotFoundException {
		dbName = nomDB;
		connection = getConnection();
	}
	
	/**
	 * Methode getDbName
	 * @return
	 * 			Le nom actuel de la base de données
	 */

	public static String getDbName() {
		return dbName;
	}
	
	/**
	 * Method setAll
	 * @param username
	 * 				Le nom d'utilisateur
	 * @param pass
	 * 				Le mot de passe
	 * @param server
	 * 				Le serveur
	 * @param port
	 * 				le port
	 * @param db
	 * 				le nom de la base
	 * @throws ClassNotFoundException
	 * 				Exception Class not found
	 * @throws SQLException
	 * 				Exception SQL
	 */
	
	public static void setAll(String username, String pass, String server, String port, String db) throws ClassNotFoundException, SQLException {
		userName = username;
		password = pass;
		serverName = server;
		portNumber = port;
		dbName = db;
		connection = getConnection();
		System.out.println("Connexion réussie !");
	}
}
