package main;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Scanner;
import java.util.Hashtable;
import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
public class Parsely {

    /** Parse the TSV file into an ArrayList of hashtables.
     * Each hashtable contains a row from the spread sheet, but
     * data is stored as (field name, value) pairs */
    public ArrayList <Hashtable<String,String>>  parseTSVfile(String filename, String delimiter) {
        ArrayList <Hashtable<String,String>> arr = new ArrayList <Hashtable<String,String>> ();
        try {
          File f = new File(filename);
          Scanner scan = new Scanner(f);

          // get first line, an array of the field names
          String s = scan.nextLine();
          System.out.println(s);
          String [] fields = s.split(delimiter); // split on tab

          System.out.println(fields.length + " fields ");
          /*for (String f1: fields) {
            System.out.println(f1);
          }*/
          while( scan.hasNext() ) {
                String t = scan.nextLine();

                // For each line, create a new hashtable, then add
                //it to ArrayList
                String [] vals = t.split(delimiter);
                Hashtable <String,String> h = new Hashtable<String,String> ();
                for (int i = 0; i < fields.length; i++) {
                     h.put(fields[i], vals[i]);
                }
                arr.add(h);


          }
          scan.close();
          System.out.println(arr.size() + " Hashtables in ArrayList");

        } catch (Exception ex) {
            System.out.println("Exception parsing " + filename);
            System.out.println(ex.toString());
            return null;
        }
        return arr;
    }

    public static void main(String [] args) {
      Parsely p = new Parsely();
      ArrayList <Hashtable<String,String>> arr
                    = p.parseTSVfile("cemetery.tsv", "\t");
      try {
			FileWriter pf = new FileWriter("dump.sql");
			pf.write("drop database if exists CemeteryDB;\n");
			pf.write("CREATE DATABASE `CemeteryDB`;\n");
			pf.write("USE `CemeteryDB`;\n");
			pf.write("DROP TABLE IF EXIST `headstones`;\n");
			pf.write("CREATE TABLE `headstones` (`stoneID` MEDIUMINT UNSIGNED AUTO_INCREMENT NOT NULL, `row_number` VARCHAR(10),`stone_number` VARCHAR(10),"
			+ "`case_number` VARCHAR(10), `gender` VARCHAR(10), `last_name` VARCHAR(255), `first_name` VARCHAR(255),"
			+ "`middle_initial` VARCHAR(10), `maiden_name` VARCHAR(255), `birth_year` DOUBLE, `birth_month` DOUBLE,"
			+ "`birth_day` INT, `death_year` DOUBLE, `death_month` DOUBLE, `death_day` INT,"
			+ "`age_year` INT, `age_month` INT, `age_day` INT, `material` VARCHAR(10), `status` VARCHAR(255),"
			+ "`symbols` VARCHAR(255),`comments` TEXT,PRIMARY KEY (`stoneID`));\n");
			ArrayList<String> colNames = new ArrayList<>(Arrays.asList(
				    "ROW#", "STONE#","CASE#", "GENDER", "LAST", "FIRST", "M.I.", "MAIDEN", 
				    "BIRTH YR", "BIRTH MO", "BIRTH DAY", "DEATH YR", "DEATH MO", 
				    "DEATH DAY", "AGE YR", "AGE MO", "AGE DAY", "MATERIAL", 
				    "STATUS", "SYMBOLS", "COMMENTS"
				));

			for(Hashtable<String, String>  a: arr) {
				String s = "INSERT INTO `headstones` VALUES(0,";
				for(String col: colNames) {
					if(a.get(col) == null || a.get(col).contains("null")) {
						if(colNames.indexOf(col) == colNames.size() -1) {
							s+=a.get(col);
							}else {
								s+=a.get(col)+",";
							}
					}else {
					if(colNames.indexOf(col) == colNames.size() -1) {
					s+="'"+a.get(col)+"'";
					}else {
						s+="'"+a.get(col) +"',";
					}
					}
				}
				s+=");";
				pf.write(s);
				pf.write("\n");
			}
			pf.close();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
      System.out.println("First record's last name is " + arr.get(0).get("LAST"));
      System.out.println("First record's comments is " + arr.get(0).get("COMMENTS"));
    }

}