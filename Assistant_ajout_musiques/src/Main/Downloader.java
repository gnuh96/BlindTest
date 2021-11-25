package Main;
import java.io.*;
import java.util.Scanner;

import javax.swing.JScrollPane;
import javax.swing.JTextArea;
import javax.swing.text.JTextComponent;

import com.beaglebuddy.mp3.MP3;

import Exceptions.DownloadException;

/**
 * Classe permettant de télécharger des musique à partir de Spotify
 * @author prugne2u
 */

public class Downloader {
	
	/**
	 * Permet de télécharger une playlist
	 * @param url
	 * 				L'url de la playlist
	 */
	
	public static void donwloadURL(String url, String dossierMusiquesProjet, String dossierMusiques) {
		String commande;
    	
    	try {
	        
	    	//Processus de classification
    		commande = "cd " + dossierMusiquesProjet +"/ && spotdl --playlist \" " +url +"\"";
	        ProcessBuilder builder = new ProcessBuilder(
	            "cmd.exe", "/c", commande);
	        builder.redirectErrorStream(true);
	        Process p = builder.start();
	        BufferedReader r = new BufferedReader(new InputStreamReader(p.getInputStream()));
	        String line;
	        while (true) {
	            line = r.readLine();
	            if (line == null) { break; }
	            System.out.println(line);
	        }
	      
	      //Renommage
	        commande = "cd " + dossierMusiquesProjet +"/ && rename *.txt playlist.txt";
	        builder = new ProcessBuilder(
	            "cmd.exe", "/c", commande);
	        builder.redirectErrorStream(true);
	        p = builder.start();
	        System.out.println("Renommage...");
	        
	        
	        //Processus de téléchargement de la playlist
	        commande = "cd " + dossierMusiquesProjet +"/ && spotdl --list playlist.txt";
	        builder = new ProcessBuilder(
		            "cmd.exe", "/c", commande);
	        builder.redirectErrorStream(true);
	        p = builder.start();
	        r = new BufferedReader(new InputStreamReader(p.getInputStream()));
	        while (true) {
	            line = r.readLine();
	            if (line == null) { break; }
	            System.out.println(line);
	        }
	        
	      //Suppression du fichier playlist
	        commande = "del /F " + dossierMusiquesProjet+"/playlist.txt";
	        builder = new ProcessBuilder(
		            "cmd.exe", "/c", commande);
	        builder.redirectErrorStream(true);
	        p = builder.start();
	        r = new BufferedReader(new InputStreamReader(p.getInputStream()));
	        System.out.println("Suppression du fichier de playlist...");
	        
	      //Déplace le fichier dans le bon dossier
	        File rep = new File(dossierMusiques);
			File[] fichiers = rep.listFiles();
			for(int i = 0; i < fichiers.length; i++) {
				if(fichiers[i].getName().contains(".mp3")) {
					MP3 mp3 = new MP3(fichiers[i]);
					if(mp3.getYear() != 0 && mp3.getTitle() != null && mp3.getLeadPerformer() != null && mp3.getMusicType() != null) {
					 	   if(fichiers[i].renameTo(new File(dossierMusiquesProjet +"/" + fichiers[i].getName()))){
					 		   System.out.println("Votre musique a correctement été ajoutée");
					 		   Request.insert(mp3.getTitle(), mp3.getLeadPerformer(), mp3.getYear(), mp3.getMusicType());
					 	   }
					}else {
						throw new DownloadException("Impossible d'obtenir les tags, annulation du téléchargement...");
					}
				}
			}
	        
    	}catch(Exception e) {
    		e.printStackTrace();
    	}
	}
	
	/**
	 * Methode downloadText
	 * Permet de télécharger une seule musique à partir de son nom
	 * Exemple : "Johnny Hallyday - Allumer le feu"
	 * @param titre
	 * 				Le titre de la musique
	 * @throws IOException
	 * 				Exception Entree/Sortie
	 * @throws DownloadException
	 * 				Exception personnalisée download
	 */
	
	public static void downloadText(String titre, String dossierMusiquesProjet, String dossierMusiques) throws IOException, DownloadException {
		String commande = "spotdl --song \" " +titre +"\"";
    	
    	try {
	    	//Processus download, Telecharge la musique dans le dossier music
	        ProcessBuilder builder = new ProcessBuilder(
	            "cmd.exe", "/c", commande);
	        builder.redirectErrorStream(true);
	        Process p = builder.start();
	        BufferedReader r = new BufferedReader(new InputStreamReader(p.getInputStream()));
	        String line;
	        while (true) {
	            line = r.readLine();
	            if (line == null) { break; }
	            System.out.println(line);
	        }
    	}catch(Exception e) {
    		e.printStackTrace();
    	}
    	
        //Déplace le fichier dans le bon dossier
    	try{
			File rep = new File(dossierMusiques);
			File[] fichiers = rep.listFiles();
			for(int i = 0; i < fichiers.length; i++) {
				if(fichiers[i].toString().contains(".mp3")) {
					MP3 mp3 = new MP3(fichiers[i]);
					if(mp3.getYear() != 0 && mp3.getTitle() != null && mp3.getLeadPerformer() != null && mp3.getMusicType() != null) {
				 	   if(fichiers[i].renameTo(new File(dossierMusiquesProjet +"/" + fichiers[i].getName()))){
				 		   System.out.println("Votre musique a correctement été ajoutée");
				 		   Request.insert(mp3.getTitle(), mp3.getLeadPerformer(), mp3.getYear(), mp3.getMusicType());
				 	   }
					}else {
						throw new DownloadException("Impossible d'obtenir les métadonnées...");
						//Suppression du fichier
					}
				}
			}
     	}catch(Exception e){
     		e.printStackTrace();
     	}
	}
}