
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

public class controller {
    private final ArrayList array1;
    private final ArrayList array2;
    private final log mylog;
    private final int maxthreads;
    private int current; // The number the master thread assigned the slaves to look for
    int from,to; //Sublist ranges
    int registered_threads; // Used to set Ranks
    private int reported;
    
    private ArrayList sublists = new ArrayList();
    private ArrayList positions = new ArrayList(); // Arraylist to be used for merging
    ArrayList[] all;
    //Variables checking if some Steps have concluded
    private boolean  found = false;
    private boolean finished =false;
    //Variables preventing the deadlocks
    boolean printflag=true,insetnum =true;
    int count_in_barrier = 0;
    int count_in_report = 0;
    boolean master_finished_step = false;
    int permissions[];
    boolean finished_reports=false;
    boolean compiling = false;
    boolean slave_can_read = false;
    //
    //Constructot of Controller and Initialization of values
    public controller(ArrayList a, ArrayList b, int maxthreads){
        this.array1 = a;
        this.array2 = b;
        registered_threads=0;
        this.maxthreads = maxthreads;
        this.permissions= new int[maxthreads+1];
        all = new ArrayList[maxthreads];
        from = 0;
        to = array1.size();
        mylog = new log(maxthreads);
    }
 
    
    
    public int get_maxthreads(){
        return this.maxthreads;
    }
  
    //-----------------------------------FUNCTIONS USED BY SLAVES-----------------------------------//
    public synchronized int get_number(int rank){
        if(rank!=0){
        while(permissions[rank] == 0){
            try {
                wait();
            } catch (InterruptedException ex) {
                Logger.getLogger(controller.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        }
        return current;
    }
    
    public synchronized int get_search_from(int rank){
        if(rank!=0){
        while(permissions[rank] == 0){
            try {
                wait();
            } catch (InterruptedException ex) {
                Logger.getLogger(controller.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        }
        return from;
    }
    
    public synchronized int get_search_to(int rank){
        if(rank!=0){
        while(permissions[rank] == 0){
            try {
                wait();
            } catch (InterruptedException ex) {
                Logger.getLogger(controller.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        }
        permissions[rank] = 0;
        return to;
    }

    public synchronized void report(int rank,String message){
        
            mylog.create_log(rank, message);
            count_in_report++;
            if(count_in_report == maxthreads){
                finished_reports = true;
                count_in_report = 0;
                notifyAll();
                
            }
    }
     
     public synchronized void barrier(){
        while(compiling){
           try {
              wait();
           } catch (InterruptedException ex) {
               Logger.getLogger(controller.class.getName()).log(Level.SEVERE, null, ex);
           }
        }
        
    }
     
    public synchronized int set_rank(){
        return registered_threads;
    }
    //-----------------------------------FUNCTIONS USED BY MASTER-----------------------------------//
     public synchronized void set_number(int number){
       
        this.reported=0;// Initializing reported threads for next step
        this.current = number;
        
    }
     
     public synchronized void master_wait_reports(){
        while(finished_reports == false){
            try {
                wait();
                
            } catch (InterruptedException ex) {
                Logger.getLogger(controller.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        compiling = true;
    }
     
    public void report_finished(){
        finished = true;
    }
    public boolean division_finished(){
        return finished;
    }
    
    public synchronized void set_search_range(int from, int to){
        
        this.from=from;
        this.to = to;
        finished_reports = false;
        compiling = false;
        slave_can_read = true;
        notifyAll();
    }
    
    public synchronized void grand_permissions_to_read(){
        for(int i=0;i<maxthreads+1;i++){
            permissions[i]=1;
        }
    }
    
    public synchronized log get_report(){
        return mylog;
    }
    
    public void report_found(int pos){
        found=true;
        positions.add(pos);
    }
    
    public void register(){
        registered_threads++;
    }
    //---------------------------------------------------------------------------------------------//
   
    int starting = 0;
    boolean in_create_final_report = true;
    //----------------------------------------Merging----------------------------------------------// 
    
    public synchronized void create_final_report(){
        for(int i=0;i<positions.size();i++){
            if((int)positions.get(i)==array2.size()-1){
                starting = array2.size()-1;
            }
            sublist temp = new sublist(starting,(int)positions.get(i));
            sublists.add(temp);
            starting = (int)positions.get(i);
            
        }
        in_create_final_report = false;
        notifyAll();
    }
    
    public void print_final_report(){
        for(int i=0;i<sublists.size();i++){
            sublist temp = (sublist)sublists.get(i);
            System.out.println("Sublist #"+i+" From ="+temp.get_from()+" To ="+temp.get_to());
        }
    }

    public synchronized sublist get_sublist(int myrank){
        while(in_create_final_report){
            try {
                wait();
            } catch (InterruptedException ex) {
                Logger.getLogger(controller.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        return (sublist)sublists.get(myrank-1);
    }
    boolean in_gather = true;
    int gather_count = 0;
    
    public synchronized void gather(int rank,ArrayList sublist){
        all[rank-1] = sublist;
        gather_count++;
        if(gather_count==maxthreads){
            in_gather=false;
            notifyAll();
        }
        
    }
    
    public synchronized ArrayList[] get_all(){
        while(in_gather){
            try {
                wait();
            } catch (InterruptedException ex) {
                Logger.getLogger(controller.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        return all;
    }
    //---------------------------------------------------------------------------------------------//
}
