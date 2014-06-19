
public class sublist {
    private int from;
    private int to;
    
    public sublist(int from,int to){
        this.from = from;
        this.to = to;
    }
    public sublist(){
        this.from = 0;
        this.to = 0;
    }
    public int get_from(){
        return from;
    }
    public int get_to(){
        return to;
    }
    public void set_from(int from){
        this.from = from;
    }
    public void set_to(int to){
        this.to=to;
    }
}
