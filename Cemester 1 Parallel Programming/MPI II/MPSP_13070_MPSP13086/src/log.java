



public class log {
    private String messages[];
    private int maxthreads;
    private int count;
    public log(int maxthreads){
        this.maxthreads = maxthreads;
        messages = new String[maxthreads];
        for(int i=0;i<maxthreads;i++){
            messages[i]="not_set";
        }
        count = 0;
    }
    public void create_log(int myrank, String message){
        messages[myrank] = message;
        count++;
    }
    
    public String[] get_log(){
        return messages;
    }
    
    public void print_log(){
        for(int i=0;i<messages.length;i++){
            System.out.println("|"+i+"|"+messages[i]);
        }
    }
    
    public int get_index(){
        int index = -3;
        for(int i=0;i<messages.length-1;i++){
            if(messages[i].equals("lower") && messages[i+1].equals("greater")){
                System.out.println("This Element has to be on the sublist = "+(i+1));
                index = i;
               
            }
        }
        if(messages[messages.length-1].equals("lower")){
            index = -1;
        }
        if(messages[0].equals("greater")){
            index = 0;
        }
        for(int i=0;i<messages.length;i++){
            messages[i] = "not_set";
        }
        count=0;
        return index;
    }
}
