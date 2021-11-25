package Main;
import java.sql.*;
import java.util.Arrays;

import Exceptions.InsertionException;

/**
 * Classe permettant d'ajouter � la base de donn�es
 * @author prugne2u
 */

public class Request {
	
	/**
	 * Methode insert
	 * Permet d'ajouter dans la base les donn�es musicales
	 * @param titre
	 * 				Le titre de la musique
	 * @param artiste
	 * 				L'artiste de la musique
	 * @param date
	 * 				La date de sortie de la musique
	 * @param genre
	 * 				Le genre de la musique
	 * @throws SQLException
	 * 				Exception li�e � la base de donn�es
	 * @throws InsertionException
	 * 				Exception li�e aux donn�es 
	 * @throws ClassNotFoundException 
	 */
	
	public static void insert(String titre, String artiste, int date, String genre) throws SQLException, InsertionException, ClassNotFoundException {
		//INSERTION DANS LA TABLE ARTISTE
		//V�rification
		String verif = "SELECT * FROM Auteur WHERE nomArtiste = ?";
		PreparedStatement stmt = DBConnection.getConnection().prepareStatement(verif);
		
		stmt.setString(1, artiste);
		ResultSet rs = stmt.executeQuery();
		
		//Insertion avec condition
		if(!rs.next()) {
			String insertion = "INSERT IGNORE INTO Auteur(nomArtiste) VALUES(?)";
		    stmt = DBConnection.getConnection().prepareStatement(insertion);
			
			stmt.setString(1, artiste);
			
			try {
				stmt.execute();
			}catch(SQLException e) {
				System.out.println(e.getMessage());
			}
		}
		
		//---------------------------------------------------------------------------------------------------
		//INSERTION DANS LA TABLE GENRE
		//V�rification
        verif = "SELECT * FROM Genre WHERE nomGenre = ?";
		stmt = DBConnection.getConnection().prepareStatement(verif);
		
		stmt.setString(1, genre);
		rs = stmt.executeQuery();
		
		//Insertion avec condition
		if(!rs.next()) {
			String insertion = "INSERT IGNORE INTO Genre(nomGenre) VALUES(?)";
			stmt = DBConnection.getConnection().prepareStatement(insertion);
			
			stmt.setString(1, genre);
			
			try {
				stmt.execute();
			}catch(SQLException e) {
				System.out.println(e.getMessage());
			}
		}

		//---------------------------------------------------------------------------------------------------
		//INSERTION DANS LA TABLE MUSIQUE
		//Recuperation de idCateg
		int idCateg;
		if(date >= 1980 && date < 1990) {
			idCateg = 1;
		}else if(date >= 1990 && date < 2000) {
			idCateg = 2;
		}else if(date >= 2000 && date < 2010) {
			idCateg = 3;
		}else if(date >= 2010 && date < 2020) {
			idCateg = 4;
		}else {
			idCateg = 0;
		}
		
		//Recuperation de idGenre
		String query = "SELECT idGenre FROM Genre WHERE nomGenre = ?";
		stmt = DBConnection.getConnection().prepareStatement(query);
		stmt.setString(1, genre);
		
		stmt.execute();
		rs = stmt.getResultSet();
		int idGenre = 0;
		while(rs.next()) {
			idGenre = rs.getInt(1);
		}
		
		//insertion
		String insertion = "INSERT IGNORE INTO Musique(titre,date,idcateg,idgenre) VALUES(?,?,?,?)";
		stmt = DBConnection.getConnection().prepareStatement(insertion);
		stmt.setString(1, titre);
		stmt.setInt(2, date);
		
		if(idCateg != 0 && idGenre != 0) {
			stmt.setInt(3, idCateg);
			stmt.setInt(4, idGenre);
		}else {
			System.out.println(idCateg);
			System.out.println(idGenre);
			throw new InsertionException("Impossible d'executer l'insertion, idCateg ou idGenre NULL");
		}
		
		try {
			stmt.execute();
		}catch(SQLException e) {
			System.out.println(e.getMessage());
		}

		//---------------------------------------------------------------------------------------------------
		//INSERTION DANS LA TABLE COMPOSE
		//Recuperation de idMusique
		query = "SELECT idMusique FROM Musique WHERE titre = ?";
		stmt = DBConnection.getConnection().prepareStatement(query);
		stmt.setString(1, titre);
		
		stmt.execute();
		rs = stmt.getResultSet();
		int idMusique = 0;
		while(rs.next()) {
			idMusique = rs.getInt(1);
		}
		
		//Recuperation de idAuteur
		query = "SELECT idAuteur FROM Auteur WHERE nomArtiste = ?";
		stmt = DBConnection.getConnection().prepareStatement(query);
		stmt.setString(1, artiste);
		
		stmt.execute();
		rs = stmt.getResultSet();
		int idAuteur = 0;
		while(rs.next()) {
			idAuteur = rs.getInt(1);
		}
		
		//insertion
		insertion = "INSERT IGNORE INTO Compose(idMusique,idAuteur) VALUES(?,?)";
		stmt = DBConnection.getConnection().prepareStatement(insertion);
		if(idMusique != 0 && idAuteur != 0) {
			stmt.setInt(1, idMusique);
			stmt.setInt(2, idAuteur);
		}else {
			throw new InsertionException("Impossible d'executer l'insertion, idMusique ou idAuteur NULL");
		}
		
		try {
			stmt.execute();
		}catch(SQLException e) {
			System.out.println(e.getMessage());
		}
		
		System.out.println("Base de donnees mise a jour");
	}
	
	/*
	public static void multichoix (Choix[] choix) throws ClassNotFoundException, SQLException {
		String id;
		int compte = 1;
		String requete = "SELECT * FROM Musique Where ? = ?";
		
		for (int i = 1; i < choix.length; i++) {
			requete += " AND ? = ?";
		}
		PreparedStatement stmt = DBConnection.getConnection().prepareStatement(requete);
		for (Choix c : choix) {
			stmt.setString(compte, c.getTypeid());
			stmt.setInt(compte+1, Integer.parseInt(c.getId()));
			compte = compte+2;
		}
		ResultSet rs = stmt.executeQuery();
		while (rs.next()) {
			
		}
		rs.close();
		stmt.close();
	}
	*/
}
