package Test;
import static org.junit.Assert.*;
import java.sql.Connection;
import java.sql.SQLException;
import org.junit.Test;

import Main.DBConnection;

public class DBConnectionTest {

	@Test
	public void testConnection() throws SQLException, InstantiationException, IllegalAccessException, ClassNotFoundException {
		Connection connectTest1 = DBConnection.getConnection();
		//Connection connectTest2 = DBConnection.getConnection();
		//assertEquals("Les connections ne sont pas les memes",connectTest1.toString(),connectTest2.toString());
	}
}
