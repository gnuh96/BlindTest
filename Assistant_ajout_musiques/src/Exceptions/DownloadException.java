package Exceptions;

/**
 * Exception personnalisee liee au telechargement
 * @author prugne2u
 */

public class DownloadException extends Exception{
	
	/**
	 * Constructeur
	 * @param message
	 * 				Le message
	 */
	
	public DownloadException(String message) {
		super(message);
	}
}
