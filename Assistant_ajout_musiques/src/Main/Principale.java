package Main;
import java.awt.*;
import java.awt.event.*;
import java.io.*;
import java.sql.SQLException;
import java.util.ArrayList;

import javax.swing.*;
import javax.swing.text.JTextComponent;
import Console.MessageConsole;
import Exceptions.DownloadException;

/**
 * Classe principale
 * @author prugne2u
 */

public class Principale {
	
	public static boolean isURL;
	
	/**
	 * Methode main
	 * Lancer le programme
	 * @param args
	 * 				arguments
	 * @throws HeadlessException
	 * 				Exception Headless
	 * @throws UnsupportedEncodingException
	 * 				Exception UnsupportedEncoding
	 */
	
	public static ArrayList<String> readConf() {
		ArrayList<String> confList = new ArrayList<String>();
		// The name of the file to open.
        String fileName = "conf.txt";

        // This will reference one line at a time
        String line = null;

        try {
            // FileReader reads text files in the default encoding.
            FileReader fileReader = 
                new FileReader(fileName);

            // Always wrap FileReader in BufferedReader.
            BufferedReader bufferedReader = 
                new BufferedReader(fileReader);

            while((line = bufferedReader.readLine()) != null) {
                if(line.contains("=")) {
                	if(line.contains("Dossier")) {
                		String[] tab = line.split(" ");
                    	confList.add(tab[5]);
                	}else {
                		String[] tab = line.split(" ");
                		if(tab.length == 2) {
                			confList.add("");
                		}else {
                			confList.add(tab[2]);
                		}	
                	}
                }
            }   

            // Always close files.
            bufferedReader.close();         
        }
        catch(FileNotFoundException ex) {
            System.out.println(
                "Unable to open file '" + 
                fileName + "'");                
        }
        catch(IOException ex) {
            System.out.println(
                "Error reading file '" 
                + fileName + "'");                  
            // Or we could just do this: 
            // ex.printStackTrace();
        }
        
        return confList;
	}
	
	public static void main(String[] args) throws HeadlessException, UnsupportedEncodingException, ClassNotFoundException, SQLException {
		//Lis le fichier config
		ArrayList<String> list = readConf();
		//Mis a jour des informations sur la base de données
		DBConnection.setAll(list.get(0), list.get(1), list.get(2), list.get(3), list.get(4));
		
		//Création de l'interface
		JPanel panel = new JPanel();
		panel.setBackground(new Color(150,150,150));
		JPanel haut = new JPanel();
		haut.setBackground(new Color(150,150,150));
		JPanel milieu = new JPanel();
		milieu.setBackground(new Color(150,150,150));
		milieu.setLayout(new BorderLayout());
		JPanel milieuBas = new JPanel();
		milieuBas.setBackground(new Color(150,150,150));
		JPanel bas = new JPanel();
		bas.setBackground(new Color(150,150,150));
		JTextField jtf = new JTextField();
		jtf.setPreferredSize(new Dimension(300,25));
		
		JTextComponent jtc = new JTextArea();
		JScrollPane js = new JScrollPane(jtc);
		js.setPreferredSize(new Dimension(500,100));
		
		JRadioButton textForm = new JRadioButton("Single Form");
		textForm.setBackground(new Color(150,150,150));
		JRadioButton urlForm = new JRadioButton("Playlist Form");
		urlForm.setBackground(new Color(150,150,150));
		
		ButtonGroup group = new ButtonGroup();
		group.add(textForm);
		group.add(urlForm);
		
		MessageConsole mc = new MessageConsole(jtc);
		mc.redirectOut(null,System.out);
		mc.redirectErr(Color.RED, null);
		mc.setMessageLines(500);
		
		JButton ajouter = new JButton("Ajouter");
		ajouter.setEnabled(false);
		ajouter.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				try {
					if (!isURL && !jtf.getText().contains("https://open.spotify.com/")){
						jtc.setForeground(Color.black);
						Downloader.downloadText(jtf.getText(), list.get(5),list.get(6));
					}else if(isURL && jtf.getText().contains("https://open.spotify.com/")){
						jtc.setForeground(Color.black);
						Downloader.donwloadURL(jtf.getText(),list.get(5),list.get(6));
					}else {
						jtc.setForeground(Color.red);
						jtc.setText("ERREUR");
					}
				} catch (IOException | DownloadException e1) {
					e1.printStackTrace();
				}
			}
		});
		
		textForm.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				isURL = false;
				ajouter.setEnabled(true);
			}
		});
		
		urlForm.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				isURL = true;
				ajouter.setEnabled(true);
			}
		});
		
		haut.add(jtf);
		haut.add(ajouter);
		
		milieuBas.add(textForm);
		milieuBas.add(urlForm);
		
		milieu.add(haut,BorderLayout.NORTH);
		milieu.add(milieuBas,BorderLayout.CENTER);
		
		bas.add(js);
		
		panel.add(milieu);
		panel.add(bas);
		
		JFrame frame = new JFrame();
		frame.add(panel);
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.setSize(new Dimension(800,400));
		frame.setVisible(true);
	}
}
