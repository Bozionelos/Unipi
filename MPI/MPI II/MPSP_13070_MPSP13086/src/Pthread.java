
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Scanner;


public class Pthread {


    public static void main(String[] args) {
        
       //Declaring The Arrays
       ArrayList array1 = new ArrayList();
       ArrayList array2 = new ArrayList();
       int maxthreads;
       //Sample Data
       System.out.println("How Many threads do you want to use");
       Scanner scan = new Scanner(System.in);
       maxthreads=scan.nextInt();
       
       array2.addAll(Arrays.asList(2,4, 7, 9, 9,16,17,19,21,26,28,29,31,34,36,41,42,44,46,49));
       array1.addAll(Arrays.asList(5,7,10,11,15,18,19,22,35,45,46,46,50,52,53,60,62,64,66,68));
       //Creating the controlling object of the shared memory
       controller control = new controller(array1,array2,maxthreads);
       //Creating the master thread
       mythread master = new mythread(array1,array2,true,"master",control);
       //Starting the master thread (run();)
       
       master.start();
       
    }
    
}
