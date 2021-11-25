package Exceptions;
/**
 * Exception personnalisee liee a l'insertion dans la base
 * @author prugne2u
 */

public class InsertionException extends Exception{
	
	/**
	 * Constructeur
	 * @param message
	 * 				Le message
	 */
	
	public InsertionException(String message) {
		super(message);
	}

}
