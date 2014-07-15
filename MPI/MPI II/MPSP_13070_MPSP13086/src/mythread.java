import java.util.ArrayList;
import java.util.Scanner;

public class mythread extends Thread{
    boolean ismaster;
    ArrayList array1,array2;
    ArrayList threads;
    int maxthreads;
    int pointer_of_sublist;
    int myrank;
    String mode;
    controller control;
    int previous_from;
    int position;
    int mysize, previous_mysize;
    boolean division_finished;
    Scanner scan = new Scanner(System.in);
    public mythread(ArrayList a, ArrayList b, boolean ismaster, String mode, controller control){
        this.array1 = a;
        this.array2 = b;
        this.ismaster = ismaster;
        myrank = control.set_rank();
        this.mode = mode;
        this.control = control;
        
    }
 
    
    @Override
    public void run(){
        maxthreads= control.get_maxthreads();
        
        if(myrank==0){
        long startTime = System.currentTimeMillis();    
            
            for(int i=0;i<maxthreads;i++){
                control.register();
                mythread t= new mythread(array1,array2,false,"slave",control);
                t.start();
            }
            boolean finished = false;
            int count = 1;
            int from;
            int to;
            int step;int remaining;
            
            while(!finished){
            

            control.set_number((int)array1.get(count*(array1.size()/maxthreads)-1));
            
            mysize = 20;
            position = 0;
            step = (control.get_search_to(0)-control.get_search_from(0))/maxthreads;
            remaining = (control.get_search_to(0)-control.get_search_from(0))%maxthreads;
            
            control.set_search_range(0,array1.size());
            while(step!=0 || remaining !=0){
                
                control.grand_permissions_to_read();
                //System.out.println("for number "+control.get_number(0)+" setting the initial range from: "+control.get_search_from(0)+" to: "+control.get_search_to(0));
                control.master_wait_reports();
                //Wait for the Slaves to wright reports//
                log mylog = control.get_report();
                //Compiling
                from = control.get_search_from(0);
                previous_mysize = mysize;
                mysize = mysize/maxthreads;
                
                previous_from += from;
                
                pointer_of_sublist = mylog.get_index();
                if(pointer_of_sublist!=-1){
                position += (pointer_of_sublist+1)*mysize;
                from = (pointer_of_sublist+1)*mysize;
                to = (pointer_of_sublist+2)*mysize;
                //System.out.println("New from and to are "+from+"|"+to);
                step = (to-from)/maxthreads;
                remaining = (to-from)%maxthreads;
                    if(step>0 ){
                    control.set_search_range(from,to);
                    }
                    else{
                    step =0;
                    remaining=0;
                    System.out.println("Element "+(int)array1.get(count*(array1.size()/maxthreads)-1)+" must enter in position "+(position-1));
                    control.report_found((position-1));
                    }
                 //End Compiling
                }  
                else{
                    
                    step =0;
                    remaining=0;
                    System.out.println("Element "+(int)array1.get(count*(array1.size()/maxthreads)-1)+" must enter at the end of the array");
                    for(int j=count;j<maxthreads+1;j++){
                    control.report_found(array1.size()-1);
                        System.out.println("All next elements will be placed at the end of the array");
                    }
                    count=maxthreads;
                    }
            }
            count++;
                
            if(count>maxthreads){
                finished = true;
                control.report_finished();
                control.set_search_range(0,0);
                control.grand_permissions_to_read();
            }
            System.out.println("------------------------------------------------------------------------------------------------");
              
            }//while finished
            control.create_final_report();
            System.out.println("Reports after Table division");
            
            
            ArrayList final_ []= control.get_all();
            for(int i = 0; i<maxthreads;i++){
                ArrayList temp = (ArrayList)final_[i];
                    for(int j=0;j<temp.size();j++){
                        System.out.print(" | "+(int)temp.get(j));
                    }
            }
            System.out.println("|");
            long endTime   = System.currentTimeMillis();
            long totalTime = endTime - startTime;
            System.out.println("Total Time in milliseconds:"+totalTime);
        } // if myrank =0
         
        else{
            int from,to;
            int max_threads = control.get_maxthreads();
            
                while(!control.division_finished()){
                    int mystep =1;
                    
                    //Wait to set number and Range
                    
                    int step = 1;
                        while(step!=0){
                            int current = control.get_number(myrank);
                            from = control.get_search_from(myrank);
                            to = control.get_search_to(myrank);
                            if(from!=to){
                            step = (to-from)/max_threads;
                            mystep = myrank*(to-from)/max_threads;
                            int check_pointer = from+(mystep)-1;
                            //System.out.println("POINTER ="+check_pointer);
                            int my_number = ((int)array2.get(check_pointer));
                            System.out.println("I am rank :"+(myrank)+" Checking my number = "+my_number+" with the curent number = "+current+" from:"+from+" to:"+to+" in pointer :"+check_pointer);
                                if(my_number==current){
                                    control.report(myrank-1,"found");
                                }
                                else if(my_number<current){
                                    control.report(myrank-1,"lower");
                                }
                                else{
                                    control.report(myrank-1,"greater");   
                                }
                        control.barrier();
                            }
                            else{
                                step=0;
                            }
                        }
                        sublist mysublist = control.get_sublist(myrank);
                        System.out.println("From ="+mysublist.get_from()+" To ="+mysublist.get_to());
                        ArrayList final_list = merge(myrank,mysublist.get_from(),+mysublist.get_to());
                        control.gather(myrank, final_list);
                        
                }//division end
                
            } 
    }
    
    public ArrayList merge(int myrank,int from,int to){
        ArrayList complete_sublist = new ArrayList();
        
        int count = 0;
        int j=0;
        int i=(myrank-1)*(array1.size()/maxthreads);
        int max_i= (myrank)*(array1.size()/maxthreads);
        int max_j= (to-from);
        int array[] = new int[max_i+max_j];
        do{
            if(i<max_i && j<max_j){
            if((int)array1.get(i)<(int)array2.get(j)){
                complete_sublist.add(array1.get(i));
                array[count]=(int)array1.get(i);
                i++;
             }
            else{
                complete_sublist.add(array2.get(j));
                array[count]=(int)array2.get(j);
                j++;
            }
            }
            else if(i<max_i){
                complete_sublist.add(array1.get(i));
                i++;
                
            }
            else if(j<max_j){
                complete_sublist.add(array2.get(j));
                j++;
                
            }
            count++;
            
        }while(count<(max_i+max_j));
        
        return complete_sublist;
    }
    
}
